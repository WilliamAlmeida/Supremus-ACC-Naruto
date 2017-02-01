var Notification = window.Notification || window.mozNotification || window.webkitNotification;

Notification.requestPermission(function (permission) {
// console.log(permission);
});

function showNotificacao(titulo, mensagem, icone) {
	window.setTimeout(function () {
		var instance = new Notification(
			titulo, {
				body: mensagem,
				icon: icone
			}
			);

		instance.onclick = function () {

		};
		instance.onerror = function () {

		};
		instance.onshow = function () {

		};
		instance.onclose = function () {

		};
	}, 1000);

	return false;
}