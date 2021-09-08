import store from './vuex/store'

const typesNotifications = {
    statusLiked: 'App\\Notifications\\StatusLiked',
};
if($('body').data('user-id')){
    Echo.private('App.User.'+$('body').data('user-id'))
        .notification(notification => {
            if(notification.type == typesNotifications.statusLiked){
                store.commit('ADD_NOTIFICATION', notification);
                Swal.fire({
                    title: 'Notificação',
                    html: '<h5>Você tem uma nova notificação.</h5>',
                    type: 'success',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 8000
                })
            }
        });
}
