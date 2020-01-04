/** MomentJS */
import moment from 'moment'
import Vue from 'vue'

Vue.filter('timeFormat', (arg) => {
    return moment(arg).format("LL");
});

Vue.filter('shortlen', (text, ln, suffix) => {
    return text.substring(0, ln) + suffix;
});
