( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-date', {
        title:'Blog Date',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog Date for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post date', 'date', 'blog date' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-date',
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