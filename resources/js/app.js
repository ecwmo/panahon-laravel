import "bootstrap";
import Alpine from "alpinejs";

import stationForm from "./components/stationForm";
import roleForm from "./components/roleForm";
import userForm from "./components/userForm";

// window._ = require("lodash");
Alpine.data("stationForm", stationForm);
Alpine.data("roleForm", roleForm);
Alpine.data("userForm", userForm);

// window.Alpine = Alpine;
Alpine.start();
