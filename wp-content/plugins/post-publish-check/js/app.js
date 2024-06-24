jQuery(document).ready(function($) {

    let previousIsSavingPost = false; 
    let isPublishing = false; 


    wp.data.subscribe(() => {
        const isSavingPost = wp.data.select('core/editor').isSavingPost();
        const isAutosavingPost = wp.data.select('core/editor').isAutosavingPost();
        const isPublishingPost = wp.data.select('core/editor').isPublishingPost();
        const currentPostStatus = wp.data.select('core/editor').getCurrentPost().status;

        if (isSavingPost !== previousIsSavingPost) {
            previousIsSavingPost = isSavingPost;
            if (isPublishingPost && !isPublishing) {
                isPublishing = true; 
            }

            if ( !isSavingPost && !isAutosavingPost && !isPublishingPost && isPublishing) {
                if(currentPostStatus === 'draft'){
                    showMessage();
                    isPublishing = false;
                }else if(currentPostStatus === 'publish'){
                    removeMessage();
                }
             
            }
        }
        
    });

    const showMessage = () =>{
        const message = "Publish Aborted! Please insert more than 2 links in the post.";
        const header = $('.editor-post-publish-panel__header');
        const headerSettings = $('.edit-post-header__settings');

        if (header.length > 0) {
            header.after(`<div class="yvg-check-post-publish-aborted" style="display: flex; color:red; font-size: 14px; width: 200px; margin: 20px auto; 0">${message} </div>`);
        }
        if (headerSettings.length > 0) {
            headerSettings.after(`<div class="yvg-check-post-publish-aborted" style="display: flex; color:red; font-size: 14px; width: 200px; margin: 20px auto; 0">${message} </div>`);
        }
    }

    const removeMessage = () =>{
        const abortedMessage = $('.yvg-check-post-publish-aborted');


        if (abortedMessage.length > 0) {
            abortedMessage.remove()
        }
    }
});