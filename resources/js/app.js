import "bootstrap";
import Alpine from "alpinejs";
import stationForm from "./components/stationForm";

// window._ = require("lodash");
Alpine.data("stationForm", stationForm);

// window.Alpine = Alpine;
Alpine.start();
