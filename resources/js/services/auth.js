import axiosRequest from './axios_config';

export default {
    login(credentials) {
        return new Promise((resolve, reject) => {
            axiosRequest().post('/api/login', {
                email: credentials.email,
                password: credentials.password,
            })
                .then(response => {
                    const token = response.data.access_token;
                    localStorage.setItem('access_token', token);
                    resolve(token)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },

    register(data) {
        return new Promise((resolve, reject) => {
            axiosRequest().post('/api/signup', {
                name: data.name,
                email: data.email,
                password: data.password,
                password_confirmation: data.password_confirmation,
            })
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    logout() {
        return new Promise((resolve, reject) => {
            axiosRequest().post('/api/logout')
                .then(response => {
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('user_info');
                    resolve(response)
                })
                .catch(error => {
                    localStorage.removeItem('user_info');
                    localStorage.removeItem('access_token');
                    reject(error)
                })
        })
    },
    getUser(){
        return new Promise((resolve, reject) => {
            axiosRequest().get('/api/auth/user')
                .then(response => {
                    const user = response.data.user;
                    localStorage.setItem('user_info', JSON.stringify(user));
                    resolve(user)
                })
                .catch(error => {
                    reject(error)
                })
        })
    }
}
