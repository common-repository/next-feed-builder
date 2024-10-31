( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-comment', {
        title:'Comment Box',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Comment Box for Design Single Blog template - Next FeedBuilder.',
        keywords: [ 'post comment', 'comment', 'comment box' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-comment',
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