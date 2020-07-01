import axiosRequest from './AxiosConfig';

export default {
    login(credentials) {
        return new Promise((resolve, reject) => {
            axiosRequest().post('/api/users/login', {
                email: credentials.email,
                password: credentials.password,
            })
                .then(response => {
                    const token = response.data.success.token;
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
                    resolve(response)
                })
                .catch(error => {
                    localStorage.removeItem('access_token')
                    reject(error)
                })
        })
    }
}
