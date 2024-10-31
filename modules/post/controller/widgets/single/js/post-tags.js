( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-tags', {
        title:'Blog Tags',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Tags for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post Tags', 'Categories', 'blog Categories' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-tags',
                    attributes: props.attributes,
                } )
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.serverSideRender,
) );