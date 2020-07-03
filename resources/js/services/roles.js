import axiosRequest from './axios_config'

export default {

    getRoles() {
        return axiosRequest().get(`/api/auth/roles`)
    },

    getRole(id) {
        return axiosRequest().get(`/api/auth/roles/${id}`)
    },

    saveRole(data) {
        return axiosRequest().post('/api/auth/roles', data)
    },

    updateRole(data, id) {
        return axiosRequest().put(`/api/auth/roles/${id}`, data)
    },

    deleteRole(id) {
        return axiosRequest().delete(`/api/auth/roles/${id}`)
    },
}
