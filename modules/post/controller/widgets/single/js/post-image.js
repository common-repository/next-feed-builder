( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-image', {
        title:'Blog Thumbnil',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Feature image for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post image', 'feature image', 'blog image' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-image',
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