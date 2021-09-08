<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\User;
use App\Models\Group;
use App\Models\UserGroup;

class ADConsultController extends Controller
{
    public function connectLdap()
    {
        $ldaprdn = 'hilton.junior@plantar.net';
        $ldappass = 'Plantar@2222';

        $ldapconn = ldap_connect('plantar.net') or die ("Could not connect to LDAP serve.");

        if($ldapconn)
        {
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            if($ldapbind)
            {
                $base_dn = 'DC=plantar,DC=net';
                //$filtro = '(&(objectClass=user)(objectCategory=person)(cn=*)(samaccountname=*))';
                $filtro = '(&(objectcategory=group)(cn=app-officium*))';
                //$param = array('givenname', 'samaccountname', 'mail');
                $ldapsearch = ldap_search($ldapconn, $base_dn, $filtro);
                $info = ldap_get_entries($ldapconn, $ldapsearch);

                if($info)
                {
                    for($i=0; $i < $info["count"]; $i++)
                    {
                        //var_dump($info);
                        $group = str_replace("app-officium-", "", $info[$i]['cn'][0]);
                        echo "Grupo: ".$group."\n";

                        if(isset($info[$i]['member']))
                        {
                            foreach($info[$i]['member'] as $key => $member)
                            {
                                //echo var_dump($member);
                                if($key != 0)
                                {
                                    $name = explode(",", $member);
                                    $name = substr($name[0], 3);

                                    $filtroUser = '(&(objectClass=user)(objectCategory=person)(CN='.$name.'*))';
                                    $ldapsearchUser = ldap_search($ldapconn, $base_dn, $filtroUser);
                                    $infoUser = ldap_get_entries($ldapconn, $ldapsearchUser);
                                    if($infoUser)
                                    {
                                        echo "Nome: ".$name." | ";

                                        $user = $infoUser[0]['samaccountname'][0];
                                        echo "Usuário: ".$user." | ";

                                        if(isset($infoUser[0]['mail'][0]))
                                        {
                                            $email = $infoUser[0]['mail'][0];
                                            echo "E-mail: ".$email." | ";
                                        }
                                        else
                                        {
                                            $email = null;
                                        }

                                        if(($infoUser[0]['useraccountcontrol'][0] == 512) || ($infoUser[0]['useraccountcontrol'][0] == 66048))
                                        {
                                            $active = 'Y';
                                            echo "Ativo: ".$active." | ";
                                        }
                                        else
                                        {
                                            $active = 'N';
                                            echo "Ativo: ".$active." | ";
                                        }

                                        $login = User::where('login', '=', $user)->first();
                                        if($login)
                                        {
                                            $login->name = $name;
                                            $login->email = $email;
                                            $login->active = $active;
                                            $login->save();

                                            //grupo
                                            echo "Grupo: ".$group." | ";
                                            $groupTbl = Group::where('description', '=', $group)->first();
                                            if($groupTbl)
                                            {
                                                $groupId = $groupTbl->group_id;
                                                echo "Grupo ID: ".$groupId." | ";

                                                $userGroup = UserGroup::where('login', '=', $user)->where('group_id', '=', $groupId)->first();
                                                if(!$userGroup)
                                                {
                                                    $dataUserGroup = [
                                                        'login' => $user,
                                                        'group_id' => $groupId
                                                    ];
                                                    $insertUserGroup = UserGroup::create($dataUserGroup);
                                                }

                                            }
                                        }
                                        else
                                        {
                                            $dataUser = [
                                                'login' => $user,
                                                'pswd' => md5("Plantar@"),
                                                'name' => $name,
                                                'email' => $email,
                                                'active' => $active
                                            ];

                                            $insertUser = User::create($dataUser);

                                            //grupo
                                            echo "Grupo: ".$group." | ";
                                            $groupTbl = Group::where('description', '=', $group)->first();
                                            if($groupTbl)
                                            {
                                                $groupId = $groupTbl->group_id;
                                                echo "Grupo ID: ".$groupId." | ";

                                                $userGroup = UserGroup::where('login', '=', $user)->where('group_id', '=', $groupId)->first();
                                                if(!$userGroup)
                                                {
                                                    $dataUserGroup = [
                                                        'login' => $user,
                                                        'group_id' => $groupId
                                                    ];
                                                    $insertUserGroup = UserGroup::create($dataUserGroup);
                                                }

                                            }
                                        }

                                    }
                                }
                                echo "\n";
                            }
                        }
                        echo "\n";
                    }
                }
                echo "\n";
                echo "LDAP bind successful ...";
            }
            else
            {
                echo "\n";
                echo "LDAP bind failed ...";
            }
        }
    }

    public function updateLdap()
    {
        $ldaprdn = 'hilton.junior@plantar.net';
        $ldappass = 'Plantar@2222';

        $ldapconn = ldap_connect('plantar.net') or die ("Could not connect to LDAP serve.");

        if($ldapconn)
        {
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            if($ldapbind)
            {
                $base_dn = 'DC=plantar,DC=net';
                $users = User::all();
                if($users)
                {
                    foreach($users as $key => $user)
                    {
                        echo "User: ".$user->login." | ";

                        $filtro = '(&(objectClass=user)(objectCategory=person)(cn=*)(samaccountname='.$user->login.'))';
                        $ldapsearch = ldap_search($ldapconn, $base_dn, $filtro);
                        $info = ldap_get_entries($ldapconn, $ldapsearch);
                        if(isset($info[0]['useraccountcontrol'][0]))
                        {
                            if(($info[0]['useraccountcontrol'][0] == 512) || ($info[0]['useraccountcontrol'][0] == 66048))
                            {
                                $active = 'Y';
                                echo "Ativo: ".$active." | ";
                            }
                            else
                            {
                                $user->active = 'N';
                                $user->save();
                                echo "Ativo: N | ";
                            }
                        }
                        echo "\n";
                    }
                }
            }
        }
    }
}
