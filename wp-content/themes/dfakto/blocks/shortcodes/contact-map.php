<?php

/*
   Google Map with infobox (empty title will hide infobox JS)
   ========================================================================== */
#TODO add custom center for map

function contact_map_shortcode()
{
    ob_start();

    $contact_map = get_field_option('map');

    if ( $contact_map && !is_admin() ) : ?>
        <div id="c-map" style="height:400px;"></div>

        <?php function set_map($contact_map) {
            $gmap_key = get_field_option( 'map_api_key' );

            if ( $gmap_key && !empty($gmap_key) && $contact_map ) :

                $markers_length = count($contact_map);
            ?>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gmap_key; ?>&callback=initMap" type="text/javascript"></script>
                <script>
                    function initMap() {
                        var markers = [
                            <?php foreach( $contact_map as $marker ) :
                                $site_lat_lng = esc_attr($marker['lat_lng']);
                                $lat_lng = explode( ',', $site_lat_lng, 2);
                                $name = wp_kses($marker['title'],['br' => []]);
                                $address = wp_kses($marker['content'],['br' => []]);
                                $address = trim($address);
                                $phone = esc_attr($marker['phone']);
                                $phone_app = esc_attr($marker['phone_app']);
                            ?>
                            <?php if ( isset( $lat_lng ) && !empty( $lat_lng ) ) : ?>
                                {
                                    "name": "<?php echo preg_replace('/\r|\n/', '',$name); ?>",
                                    "lat": "<?php echo esc_attr($lat_lng[0]); ?>",
                                    "lng": "<?php echo esc_attr($lat_lng[1]); ?>",
                                    "address": "<?php echo preg_replace('/\r|\n/', '',$address); ?>",
                                    "phone": "<?php echo $phone; ?>",
                                    "phone2": "<?php echo $phone_app; ?>",
                                     <?php /*"img": "<?php echo isset( $img ) && !empty( $img ) ? $img : img_url( 'map-logo.png' ); ?>",  */ ?>
                                },
                            <?php endif; ?>
                        <?php endforeach; ?>
                        ];

                        const iconFillColor = getComputedStyle(document.documentElement).getPropertyValue('--we-map-fill-icon-color');
                        const iconStrokeColor = getComputedStyle(document.documentElement).getPropertyValue('--we-map-stroke-icon-color');

                        <?php
                            $map_style = get_field_option('map_style') ? 'styles: '. get_field_option('map_style') : '';
                            $map_zoom = get_field_option('map_zoom');
                            $map_center = get_field_option('map_center');
                        ?>

                        const customIcon = {
                            path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
                            fillColor: iconFillColor ? iconFillColor : '#e4282b',
                            fillOpacity: 1,
                            strokeColor: iconStrokeColor ? iconStrokeColor : '#fff',
                            strokeWeight: 2,
                            scale: 1,
                        };
                        const mapOptions = {
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            <?php echo $map_style; ?>
                        };
                        const map = new google.maps.Map(document.getElementById('c-map'), mapOptions);
                        const bounds = new google.maps.LatLngBounds();
                        const infoWindow = new google.maps.InfoWindow();

                        for (let i = 0; i < markers.length; i++) {
                            let data = markers[i];
                            let marker = new google.maps.Marker({
                                position: new google.maps.LatLng(data.lat, data.lng),
                                icon: customIcon,
                                map: map,
                            });

                            <?php if ( $markers_length == 1 && $map_center ) : ?>
                                bounds.extend(new google.maps.LatLng(<?php echo esc_attr($map_center); ?>));
                            <?php else : ?>
                                bounds.extend(marker.position);
                            <?php endif; ?>

                            <?php if ( !empty( $name ) ) : ?>
                                (function (marker, data) {
                                    google.maps.event.addListener(marker, 'click', function (e) {
                                        var content = `
                                            <div class="ib-title">${data.name}</div>
                                            <div class="ib-content">${data.address}</div>
                                            <div class="ib-phone">
                                                <a href="tel:${data.phone2}">${data.phone}</a>
                                            </div>
                                        `;
                                        infoWindow.setContent(content);
                                        infoWindow.open(map, marker);
                                    });
                                })(marker, data);
                                google.maps.event.addListener(map, 'click', function(e) {
                                    infoWindow.close();
                                });
                            <?php endif; ?>
                        }

                        map.fitBounds(bounds);

                        <?php if ( $markers_length == 1 && $map_zoom ) : ?>
                            let listener = google.maps.event.addListener(map, 'idle', function() {
                                map.setZoom(<?php echo intval($map_zoom); ?>);
                                google.maps.event.removeListener(listener);
                            });
                        <?php endif; ?>
                    }
                </script>
            <?php endif;
        }
        add_action( 'wp_footer', function() use($contact_map) { set_map($contact_map); }, 100 );

    endif;

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
add_shortcode( 'contact-map', 'contact_map_shortcode' );
