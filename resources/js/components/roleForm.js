export default (role = { id: null }) => ({
    role: role,
    modalIsVisible: false,
    deleteRole(id) {
        this.role["id"] = id;
        this.modalIsVisible = true;
    },
    closeModal() {
        this.modalIsVisible = false;
    },
});
