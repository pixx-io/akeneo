'use strict';

define(
    ['jquery', 'underscore', 'routing'], function ($, _, Routing) {
        return {
            getMediaShowUrl: function (filePath, filter) {
                if ('string' === typeof filePath && filePath.startsWith('http', 0)) {
                    let parts = filePath.split('|');
                    if (filter === 'thumbnail_small' || filter === 'thumbnail') {
                        if (2 === parts.length) {
                            const regexQ = /\?w=\d{0,5}/m; // filter '?w=12345'
                            const regexA = /\&w=\d{0,5}/m; // filter '&w=12345'
                            let url = parts[1].replace(regexQ, '?w=142');
                            url = url.replace(regexA, '&w=142')
                            return url;
                        }
                    }
                    // filter === 'preview' or empty
                    return parts[0];
                }

                var filename = encodeURIComponent(filePath);

                // In case the filepath is already a direct URL to an asset preview, directly returns it
                if (filePath && filePath.includes('rest/asset_manager/image_preview')) {
                    return filePath;
                }

                return Routing.generate(
                    'pim_enrich_media_show', {
                        filename: filename,
                        filter: filter,
                    }
                );
            },

            getMediaDownloadUrl: function (filePath) {
                if ('string' === typeof filePath && filePath.startsWith('http', 0)) {
                    return filePath.split('|')[0];
                }

                var filename = encodeURIComponent(filePath);

                return Routing.generate(
                    'pim_enrich_media_download', {
                        filename: filename,
                    }
                );
            },
        };
    }
);
