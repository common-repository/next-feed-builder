( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-author', {
        title:'Blog Author',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Author for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post author', 'author', 'blog author' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-author',
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