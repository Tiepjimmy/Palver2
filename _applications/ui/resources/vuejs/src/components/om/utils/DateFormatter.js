import moment from 'moment';
export default {
    'DD/MM/YYYY': date => moment(date).format('DD/MM/YY'),
    'DD/MM/YYYY hh:ii:ss': date => moment(date).format('DD/MM/YYYY hh:mm:ss'),
};
