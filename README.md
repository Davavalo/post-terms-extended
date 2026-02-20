This plugin is an exercise in extending core WordPress blocks. It extends the core/post-terms block by adding an isLink attribute. The attribute defaults to true, since Post Terms (categories and tags) link to their archive pages by default in the core block.

It uses the <a href="https://developer.wordpress.org/reference/hooks/register_block_type_args/">register_block_type_args</a> filter to add the isLink attribute to the block on the PHP side.

It then uses the <a href="https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#editor-blockedit">editor.BlockEdit</a> filter to render a settings panel in the editor, allowing users to toggle the isLink attribute on or off. The <a href="https://developer.wordpress.org/reference/hooks/render_block_this-name/">render_block_{$this->name}</a> is then used to strip the <a> tag from the post terms on the front end. 
