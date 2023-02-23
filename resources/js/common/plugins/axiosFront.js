import axios from 'axios';
import { message } from "ant-design-vue";

var axiosFront = axios.create({
	baseURL: window.config.path + '/api/v1'
});

// Axios default headers
axiosFront.defaults.headers['Accept'] = 'application/json';
axiosFront.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosFront.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

// Axios jwt token by default
if (localStorage.getItem('front_auth_token')) {
	axiosFront.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('front_auth_token');
}
// Axios error listener
axiosFront.interceptors.response.use(function (response) {
	return response.data;
}, function (error) {
	const errorCode = error.response.status;

	if (errorCode === 401) {
		// If error 401 redirect to login
		window.location.href = window.config.path;
		delete window.axiosFront.defaults.headers.common.Authorization;
		localStorage.removeItem('front_auth_token');
		localStorage.setItem('front_auth_user', null);
		// throw new Error('Unauthorized');
	} else if (errorCode === 400) {
		var errMessage = error.response.data.error.message;
		message.error(errMessage);
	} else if (errorCode === 403) {
		var errMessage = error.response.data.error.message;
		message.error(errMessage);
	} else if (errorCode === 404) {
		var errMessage = error.response.data.error.message;
		message.error(errMessage);
	}

	return Promise.reject(error.response);
});

/**
 * Set global so you don't have to import it
 */
window.axiosFront = axiosFront;
