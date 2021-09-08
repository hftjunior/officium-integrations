<template>
    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <span class="label label-warning">{{ notifications.length }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">Você tem {{ notifications.length }} notificações</li>
            <li>
                <ul class="menu">
                  <li v-for="notification in notifications" :key="notification.id">
                    <a href="#">
                        <i class="fa fa-users text-aqua"></i> {{ notification.data.message }}
                        <small @click.prevent="markAsRead(notification.id)" class="pull-right"><i class="fa fa-fw fa-eye"></i></small>
                    </a>
                  </li>
                </ul>
            </li>
            <li class="footer"><a href="#" @click.prevent="markAllAsRead()">Limpar</a></li>
        </ul>
    </li>
</template>

<script>
export default {
    created () {
        this.$store.dispatch('loadNotifications')
    },
    computed:{
        notifications () {
            return this.$store.state.notifications.items
        }
    },
    methods: {
        markAsRead (idNotification) {
            this.$store.dispatch('markAsRead', {id: idNotification})
        },
        markAllAsRead (){
            this.$store.dispatch('markAllAsRead')
        }
    }
}
</script>
