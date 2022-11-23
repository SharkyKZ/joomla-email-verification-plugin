/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
(() => {
	const options = Joomla.getOptions('plg_system_emailverification');
	document.addEventListener("DOMContentLoaded", () => {
		const button = document.getElementById(options.buttonId);
		button.addEventListener("click", () => {
			sendVerificationCode(document.getElementById('jform_email1').value);
		});
	});

	const sendVerificationCode = (email) => {
		Joomla.request({
			method: 'POST',
			url: options.url,
			data: 'email=' + encodeURIComponent(email),
			onSuccess: (response) => {
				let message;
				let success = false;
				try {
					const result = JSON.parse(response);

					if (!result.success)
					{
						message = result.message || result.messages[0];
					}
					else
					{
						success = result.data[0].success;
						message = result.data[0].message;
					}
				} catch (exception) {
					message = exception;
				}

				renderMessage(message, success);
			},
			onError: function onError(xhr) {
				renderMessage(xhr.statusText, success);
			},
		});
	};

	const renderMessage = (message, success) => {
		let element = document.getElementById(options.messageId);
		element.innerText = message;

		const classesToRemove = success ? options.errorClasses : options.successClasses;
		const classesToAdd = success ? options.successClasses : options.errorClasses;

		classesToRemove.forEach((className) => {
			element.classList.remove(className);
		});

		classesToAdd.forEach((className) => {
			element.classList.add(className);
		});
	};
})();
