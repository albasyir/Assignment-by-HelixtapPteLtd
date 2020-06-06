import Axios from "axios";

Axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Axios.defaults.headers.common["Content-Type"] = "application/json";

export default Axios;
