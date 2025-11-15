fetchNotifications();


setInterval(() => {
    fetchNotifications();
    
}, 8000);

function fetchNotifications()
{
    let baseUrl = $('meta[name="base-url"]').attr('content');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: baseUrl+'/notify/my_notify',
        type: 'POST', // O 'POST' según lo que necesites
        dataType: 'json',
        // data:{},
        success: function(response) {
            var list = $("#list-notification");
                list.html("");
            if(response.length)
            {
                $("#grap-notification").find("#countable-notification").html(response.length+" New");


                list.html("");
                $.each(response, function (index, notification) {
                    let isRead = notification.read_at ? "text-muted" : "fw-bold"; // Clase para notificación leída o no leída
          
                    let notificationItem = `
                      <li class="list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <span class="avatar-initial rounded-circle bg-label-${notification.data.level}">
                                ${notification.data.icon}
                              </span>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-1 small ${isRead}">${notification.data.title}</h6>
                            <small class="mb-1 d-block text-body">${notification.data.message}</small>
                            <small class="text-muted">${timeAgo(notification.created_at)}</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read" onclick="markAsRead('${notification.id}')">
                              <span class="badge badge-dot"></span>
                            </a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive" onclick="deleteNotification('${notification.id}')">
                              <span class="ri-close-line ri-20px"></span>
                            </a>
                          </div>
                        </div>
                      </li>`;
          
                      list.append(notificationItem);
                  });
            }
            // console.log('Respuesta del servidor:', response);
        },
        error: function(error) {
            console.error('Error en la petición:', error);
        }
    });
}



function timeAgo(dateString) {
    let date = new Date(dateString);
    let now = new Date();
    let diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return "Just now";
    let diffInMinutes = Math.floor(diffInSeconds / 60);
    if (diffInMinutes < 60) return diffInMinutes + " min ago";
    let diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) return diffInHours + " hr ago";
    let diffInDays = Math.floor(diffInHours / 24);
    return diffInDays + " days ago";
  }

  function markAsRead(notificationId) {
    let baseUrl = $('meta[name="base-url"]').attr('content');
    $.ajax({
        url: baseUrl+`/notify/${notificationId}/read`,
    //   url: `/api/notifications/${notificationId}/read`,
      method: "POST",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      success: function () {
        fetchNotifications();
      },
      error: function (xhr, status, error) {
        console.error("Error al marcar como leída:", error);
      },
    });
  }

  function deleteNotification(notificationId) {
    // $.ajax({
    //   url: `/api/notifications/${notificationId}`,
    //   method: "DELETE",
    //   headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    //   success: function () {
    //     fetchNotifications();
    //   },
    //   error: function (xhr, status, error) {
    //     console.error("Error al eliminar notificación:", error);
    //   },
    // });
  }