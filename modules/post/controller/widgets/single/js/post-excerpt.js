( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-excerpt', {
        title:'Blog Excerpt',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Excerpt for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post Excerpt', 'Excerpt', 'blog Excerpt' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-excerpt',
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