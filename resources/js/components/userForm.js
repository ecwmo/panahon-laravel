export default (user = { id: null }, roles = [], userRoleIds = []) => ({
    user: user,
    roles: roles,
    modalIsVisible: false,
    userRoleIds: userRoleIds,
    roleSelectShow: false,
    deleteUser(id) {
        this.user['id'] = id;
        this.modalIsVisible = true;
    },
    closeModal() {
        this.modalIsVisible = false;
    },
    get userRoleNames() {
        return this.userRoleIds.map(
            (id) => this.roles.filter((role) => role['id'] == id)[0]['name']
        );
    },
});
