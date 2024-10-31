( function( blocks, element, serverSideRender ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
 
    registerBlockType( 'nextfeed/post-share', {
        title:'Share Post',
        icon: 'shield',
        category: 'nextfeed-post-single',
        description: 'Blog share provider for share post on social media - Next FeedBuilder.',
        keywords: [ 'post share', 'share', 'blog share' ],
        edit: function( props ) {
            return (
                el( ServerSideRender, {
                    block: 'nextfeed/post-share',
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