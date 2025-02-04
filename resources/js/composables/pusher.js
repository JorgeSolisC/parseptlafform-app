import Pusher from 'pusher-js';

const options = {
    cluster: 'us2',
    forceTLS: false,
}
const pusher = new Pusher('880007788b23b4fc7542', options);
let event =  pusher.subscribe('dashboard');

export function usePusherEvent() {
    return event;
}