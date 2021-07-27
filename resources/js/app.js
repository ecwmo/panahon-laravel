import "bootstrap";
import Alpine from "alpinejs";

import stationForm from "./components/stationForm";
import roleForm from "./components/roleForm";

// window._ = require("lodash");
Alpine.data("stationForm", stationForm);
Alpine.data("roleForm", roleForm);

// window.Alpine = Alpine;
Alpine.start();
