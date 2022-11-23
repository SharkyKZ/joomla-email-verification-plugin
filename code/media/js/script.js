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

	const sendVerificationCode = (input) => {
		Joomla.request({
			method: 'POST',
			url: options.url,
			data: 'email=' + input,
			onSuccess: (response) => {
				let message;
				try {
					const result = JSON.parse(response);

					if (!result.success)
					{
						console.log(result);
						message = result.message || result.messages[0];
					}
					else
					{
						console.log(result.data);
						message = result.data[0].message;

					}
				} catch (exception) {
					message = exception;
				}

				renderMessage(message);
			},
			onError: function onError(xhr) {
				renderMessage(xhr.statusText);
			},
		});
	};

	const renderMessage = (message, type) => {
		let element = document.getElementById(options.messageId);
		element.innerText = message;
		element.classList.add(type);
	};
})();
