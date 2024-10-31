( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-content', {
        title:'Blog Content',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Content for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post Content', 'Content', 'blog Content' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-content',
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