import Vue from 'vue';

export class MutationHelpers {
    static UPDATE(obj, props, payload) {
        if (!payload instanceof Object) {
            throw Exception('payload must be instance of Object');
        }

        Object.keys(payload).map(key => {
            return props.includes(key) && Vue.set(obj, key, payload[key]);
        });
    }
}
