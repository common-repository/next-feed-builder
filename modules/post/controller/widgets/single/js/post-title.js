( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-title', {
        title:'Blog Title',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Title for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post title', 'title', 'blog title' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-title',
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