wp.domReady( () => {
    wp.blocks.unregisterBlockStyle('core/button', 'outline');
    wp.blocks.unregisterBlockStyle('core/button', 'fill');

    wp.blocks.registerBlockStyle( 'core/cover', {
        name: 'has-parallax',
        label: 'Parallax',
    });

    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-primary',
        label: 'Primaire',
        isDefault: true,
    });
    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-dark',
        label: 'Noir',
    });
    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-white',
        label: 'blanc',
    });
    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-outline-primary',
        label: 'Bordure Primaire',
    });
    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-outline-dark',
        label: 'Bordure Noire',
    });
    wp.blocks.registerBlockStyle( 'core/button', {
        name: 'btn-outline-white',
        label: 'Bordure Blanche',
    });

    wp.blocks.registerBlockStyle( 'core/columns', {
        name: 'reversed-columns-md',
        label: 'Inverser tablette',
    });
    wp.blocks.registerBlockStyle( 'core/columns', {
        name: 'reversed-columns-sm',
        label: 'Inverser mobile',
    });

    wp.blocks.registerBlockStyle( 'core/paragraph', {
        name: 'max-width-600',
        label: 'Largeur 600',
    });
    wp.blocks.registerBlockStyle( 'core/paragraph', {
        name: 'max-width-800',
        label: 'Largeur 800',
    });
});
