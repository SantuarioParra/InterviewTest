import axiosRequest from './AxiosConfig'

export default {

    getUsers(page) {
        return axiosRequest().get(`/api/auth/users?page=${page}`)
    },

    getUser(id) {
        return axiosRequest().get(`/api/auth/users/${id}`)
    },

    saveUser(data) {
        return axiosRequest().post('/api/auth/users', data)
    },

    updateUser(data, id) {
        return axiosRequest().put(`/api/auth/users/${id}`, data)
    },

    deleteUser(id) {
        return axiosRequest().delete(`/api/auth/users/${id}`)
    },

    restoreUser(id) {
        return axiosRequest().delete(`/api/auth/users/restore/${id}`)
    }
}
