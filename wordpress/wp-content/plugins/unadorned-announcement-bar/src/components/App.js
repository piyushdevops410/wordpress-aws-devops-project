import { Button, TextControl, Card, CardBody } from '@wordpress/components';
import { useState } from '@wordpress/element';

const App = () => {
    const [text, setText] = useState('');

    return (
        <Card>
            <CardBody>
                <h2>Announcement Bar Settings</h2>

                <TextControl
                    label="Announcement Text"
                    value={text}
                    onChange={(value) => setText(value)}
                />

                <Button variant="primary">
                    Save
                </Button>
            </CardBody>
        </Card>
    );
};

export default App;