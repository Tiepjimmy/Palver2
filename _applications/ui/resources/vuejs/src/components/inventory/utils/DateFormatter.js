import moment from "moment";

window.moment = moment;
export default {
    "DD/MM/YYYY": date => moment(date).format("DD/MM/YY"),
};
