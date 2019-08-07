const p = require('../package');
module.exports = {
    app: {
        name: p.name,
        description: p.description,
        version: p.version
    },
    server: {
        port: process.env.NODE_APP_INSTANCE || 5005
    },
    template: {
        path: 'app/views',
        options: {
            extension: 'html',
            cache: false
        }
    },
    user: {
        name: "dimabendera"
    },
    moderation: {
        regionOCRModeration: {
            base_dir: "C:/Users/User/nomeroff-net/moderation/public/ocr/test/",
            options: {
                region_id: ["kz"],
                state_id: ["not filled"]
            }
        }
    }
};