export default (station = { id: null }) => ({
    station: station,
    mobileNumberInputEnabled: true,
    modalIsVisible: false,
    deleteStation(id) {
        console.log(this.station);
        this.station["id"] = id;
        this.modalIsVisible = true;
    },
    closeModal() {
        this.modalIsVisible = false;
    },
    toggleMobileNumber() {
        console.log(this.station);
        if (this.station["station_type"] !== "SMS") {
            this.mobileNumberInputEnabled = false;
        } else {
            this.mobileNumberInputEnabled = true;
        }
    },
});
