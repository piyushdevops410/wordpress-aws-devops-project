import {
    Button,
    TextControl,
    ToggleControl,
    Card,
    CardBody,
    SelectControl,
    Notice,
    Spinner
} from '@wordpress/components';

import { ColorPalette } from '@wordpress/block-editor';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

const App = () => {
    // State
    const [text, setText] = useState('');
    const [enabled, setEnabled] = useState(false);
    const [bgColor, setBgColor] = useState('#000000');
    const [textColor, setTextColor] = useState('#ffffff');
    const [position, setPosition] = useState('bottom');

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [notice, setNotice] = useState(null);

    // Load settings
    useEffect(() => {
        apiFetch({ path: '/wp/v2/settings' })
            .then((data) => {
                if (data.uab_settings) {
                    setText(data.uab_settings.text || '');
                    setEnabled(data.uab_settings.enabled || false);
                    setBgColor(data.uab_settings.bgColor || '#000000');
                    setTextColor(data.uab_settings.textColor || '#ffffff');
                    setPosition(data.uab_settings.position || 'bottom');
                }
                setLoading(false);
            })
            .catch(() => {
                setNotice({ type: 'error', message: 'Failed to load settings' });
                setLoading(false);
            });
    }, []);

    // Save settings
    const saveSettings = () => {
        setSaving(true);
        setNotice(null);

        apiFetch({
            path: '/wp/v2/settings',
            method: 'POST',
            data: {
                uab_settings: {
                    text,
                    enabled,
                    bgColor,
                    textColor,
                    position,
                },
            },
        })
            .then(() => {
                setNotice({ type: 'success', message: 'Settings saved successfully!' });
            })
            .catch(() => {
                setNotice({ type: 'error', message: 'Failed to save settings' });
            })
            .finally(() => {
                setSaving(false);
            });
    };

    // Loading UI
    if (loading) {
        return (
            <div style={{ padding: '20px' }}>
                <Spinner />
            </div>
        );
    }

    return (
        <Card style={{ maxWidth: '800px' }}>
            <CardBody>
                <h2>Announcement Bar Settings</h2>

                {/* Notice */}
                {notice && (
                    <Notice
                        status={notice.type}
                        isDismissible={true}
                        onRemove={() => setNotice(null)}
                    >
                        {notice.message}
                    </Notice>
                )}

                {/* Text */}
                <TextControl
                    label="Announcement Text"
                    value={text}
                    onChange={setText}
                />

                {/* Enable Toggle */}
                <ToggleControl
                    label="Enable Announcement Bar"
                    checked={enabled}
                    onChange={setEnabled}
                />

                {/* Background Color */}
                <div style={{ marginTop: '20px' }}>
                    <strong>Background Color</strong>
                    <ColorPalette
                        value={bgColor}
                        onChange={setBgColor}
                    />
                </div>

                {/* Text Color */}
                <div style={{ marginTop: '20px' }}>
                    <strong>Text Color</strong>
                    <ColorPalette
                        value={textColor}
                        onChange={setTextColor}
                    />
                </div>

                {/* Position */}
                <SelectControl
                    label="Position"
                    value={position}
                    options={[
                        { label: 'Top', value: 'top' },
                        { label: 'Bottom', value: 'bottom' },
                    ]}
                    onChange={setPosition}
                />

                {/* Save Button */}
                <div style={{ marginTop: '20px' }}>
                    <Button
                        variant="primary"
                        onClick={saveSettings}
                        disabled={saving}
                    >
                        {saving ? 'Saving...' : 'Save Settings'}
                    </Button>
                </div>
            </CardBody>
        </Card>
    );
};

export default App;