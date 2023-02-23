import { notification } from 'ant-design-vue';
import { forEach } from "lodash-es";

const processRequestFront = (configObject) => {

	const { url, data, success, error, t } = configObject;
	var formData = {};

	// Replace undefined values to null
	forEach(data, function (value, key) {
		if (value == undefined) {
			formData[key] = null;
		} else {
			formData[key] = value;
		}
	});

	axiosFront
		.post(url, formData)
		.then(response => {
			success(response.data);
		})
		.catch(errorResponse => {
			const err = errorResponse.data;
			const errorCode = errorResponse.status;
			var errorRules = {};

			if (errorCode == 422) {
				if (err.error && typeof err.error.details != "undefined") {
					var keys = Object.keys(err.error.details);
					for (var i = 0; i < keys.length; i++) {
						// Escape dot that comes with error in array fields
						var key = keys[i].replace(".", "\\.");

						errorRules[key] = {
							required: true,
							message: err.error.details[keys[i]][0],
						};
					}
				}

				error(errorRules);
			} else if (errorCode == 406) {
				error(err);
			} else if (errorCode == 403) {
				notification.error({
					message: t("common.success"),
				});
			}
		}).then(() => {
			// button.disabled = false;
		});
}

export default processRequestFront;