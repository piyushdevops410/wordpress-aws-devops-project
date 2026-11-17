import { render } from '@wordpress/element';
import App from './components/App';

document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('uab-admin-root');

    if (root) {
        render(<App />, root);
    }
});