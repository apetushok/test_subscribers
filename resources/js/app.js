import './bootstrap';
import {SubscribersManager} from './pages/subscribers'

try {
    switch (document.querySelector('meta[name="route"]').getAttribute('content')) {
        case 'subscribers':
            (new SubscribersManager()).events()
            break
    }

} catch (error) {
    console.error(error)
}
