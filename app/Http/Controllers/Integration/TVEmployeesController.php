<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Models\Person;
use App\Models\PersonEmployee;
use App\Models\PersonCategory;
use App\Models\PersonHasCategory;
use App\Models\PersonRelated;
use App\Models\PersonEmployeePayment;
use App\Models\PersonEmployeeShift;
use App\Models\PersonEmployeeRole;


class TVEmployeesController extends Controller
{
    public function soapTotvs($method, $params)
    {
        $link = env('WS_TV_QUERY_LINK');
        $options = array(
            'soap_version'  =>SOAP_1_1,
            'exceptions'    =>true,
            'trace'         =>1,
            'cache_wsdl'    =>WSDL_CACHE_DISK,
            'login'         => env('WS_TV_USER'),
            'password'      => env('WS_TV_PSWD')
        );

        $objSoaClient = new SoapClient($link, $options);
        $objResponse = $objSoaClient->__soapCall($method, array('parameters' => $params));
        return simplexml_load_string($objResponse->RealizarConsultaSQLResult);
    }

    public function getEmployees()
    {
        $arrayParams = array(
            'codSentenca'   => 'wsGePessoas',
            'codColigada'   => '0',
            'codSistema'    => 'W',
            'parameters'    => ''
        );

        $datas = $this->soapTotvs('RealizarConsultaSQL', $arrayParams);

        foreach($datas as $key => $data)
        {
            $matric = str_replace("-", "", $data->MATRIC);
            //echo "MATRIC: ".$matric;

            // employee data
            $cnpj = str_replace("-", "", str_replace("/", "", str_replace(".", "", $data->CGC)));
            //echo " | CNPJ: ".$cnpj;

            $employer = Person::where('cpfcnpj', '=', $cnpj)->first();
            if($employer)
            {
                $employer_id = $employer->id;
            }
            else
            {
                $employer_id = null;
            }

            $gender = $data->SEXO;

            $cbo = $data->CBO;
            $role = PersonEmployeeRole::where('code', '=', $cbo)->first();
            if($role)
            {
                $role_id = $role->id;
            }
            else
            {
                $role_id = null;
            }

            $payment = PersonEmployeePayment::where('payment', '=', 'Mensal')->first();
            if($payment)
            {
                $payment_id = $payment->id;
            }
            else
            {
                $payment_id = null;
            }

            $employee = PersonEmployee::where('code', '=', $matric)->first();
            if($employee)
            {
                try
                {
                    $employee->employer_id = $employer_id;
                    $employee->gender = $gender;
                    $employee->role_id = $role_id;
                    $employee->payment_id = $payment_id;
                    $employee->updated_at = date('Y-m-d H:i:s');
                    $employee->save();
                }
                catch (\Exception $e)
                {
                    echo "\n";
                    echo "| ERROR | ".$e->getMessage();
                    echo "\n";
                    continue;
                }

            }
            else
            {
                $cpf = $data->CPF;
                $person = Person::where('cpfcnpj', '=', $cpf)->first();
                if($person)
                {
                    try
                    {
                        $idPerson = $person->id;
                        $category = PersonCategory::where('category', '=', 'Colaborador')->first();
                        if($category)
                        {
                            $personHasCategory = PersonHasCategory::where('person_id', '=', $idPerson)
                                                                  ->where('person_category_id', '=', $category->id)
                                                                  ->first();
                            if(!$personHasCategory)
                            {
                                $dataInsertPersonCategory = [
                                    "person_id" => $idPerson,
                                    "person_category_id" => $category->id,
                                    "created_at" => date('Y-m-d H:i:s')
                                ];
                                $insertPersonCategory = PersonHasCategory::create($dataInsertPersonCategory);
                            }

                        }

                        $dataInsertEmployee = [
                            "code" => $matric,
                            "people_id" => $idPerson,
                            "employer_id" => $employer_id,
                            "gender" => $gender,
                            "role_id" => $role_id,
                            "payment_id" => $payment_id,
                            "shift_id" => 1,
                            "salary" => 0,
                            "status" => "A",
                            "created_at" => date('Y-m-d H:i:s')
                        ];
                        $insertPersonEmployee = PersonEmployee::create($dataInsertEmployee);
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }
                }
                else
                {
                    $name = $data->COLABORADOR;
                    //echo " | NAME: ".$name;

                    $cpfcnpj = $data->CPF;
                    //echo " | CPFCNPJ: ".$cpfcnpj;

                    $type = "F";
                    //echo " | TYPE: ".$type;

                    $dataInsertPerson = [
                        "name" => $name,
                        "cpfcnpj" => $cpfcnpj,
                        "type"  => $type,
                        "created_at" => date('Y-m-d H:i:s')
                    ];
                    try
                    {
                        $insertPerson = Person::create($dataInsertPerson);
                        $idPerson = $insertPerson->id;

                        $category = PersonCategory::where('category', '=', 'Colaborador')->first();
                        if($category)
                        {
                            $dataInsertPersonCategory = [
                                "person_id" => $idPerson,
                                "person_category_id" => $category->id,
                                "created_at" => date('Y-m-d H:i:s')
                            ];
                            $insertPersonCategory = PersonHasCategory::create($dataInsertPersonCategory);
                        }

                        $dataInsertEmployee = [
                            "code" => $matric,
                            "people_id" => $idPerson,
                            "employer_id" => $employer_id,
                            "gender" => $gender,
                            "role_id" => $role_id,
                            "payment_id" => $payment_id,
                            "shift_id" => 1,
                            "salary" => 0,
                            "status" => "A",
                            "created_at" => date('Y-m-d H:i:s')
                        ];
                        $insertPersonEmployee = PersonEmployee::create($dataInsertEmployee);
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }
                }
            }
            //echo "\n";
        }
    }

    public function setActiveEmployees()
    {
        $employees = PersonEmployee::where("status", "=", "A")->get();
        foreach($employees as $employee)
        {
            $matricula = substr($employee->code, 0, 3)."-".substr($employee->code, 3, 5);
            //echo "MATRICULA: ".$matricula;
            $cpfcnpj = $employee->employer->cpfcnpj;
            $cpfcnpj = substr($cpfcnpj, 0, 2).".".substr($cpfcnpj, 2, 3).".".substr($cpfcnpj, 5, 3)."/".substr($cpfcnpj, 8, 4)."-".substr($cpfcnpj, 12, 2);
            //echo " | CNPJ: ".$cpfcnpj;
            $arrayParams = array(
                'codSentenca'   => 'wsColaboradores',
                'codColigada'   => '0',
                'codSistema'    => 'W',
                'parameters'    => 'matricula='.$matricula.";cgc=".$cpfcnpj
            );

            $datas = $this->soapTotvs('RealizarConsultaSQL', $arrayParams);

            foreach($datas as $key => $data)
            {
                //echo " | NOME: ".$data->NOME;
                $codSituacao = $data->CODSITUACAO;
                $cgc = $data->CGC;
                if($codSituacao == "D")
                {
                    try
                    {
                        $employee->status = "I";
                        $employee->save();
                        //echo " | INATIVO ";
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }

                }
                else
                {
                    try
                    {
                        $employee->status = "A";
                        $employee->save();
                        //echo " | ATIVO ";
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }
                }
                echo "\n";
            }
            echo "\n";
        }

    }
}
