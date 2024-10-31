( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-categories', {
        title:'Blog Categories',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Categories for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post Categories', 'Categories', 'blog Categories' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-categories',
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