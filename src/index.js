/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { InspectorControls } from '@wordpress/block-editor';
import { ExternalLink, PanelBody, PanelRow, ToggleControl } from '@wordpress/components';



/**
 * Render the link toggle in the Term block Settings Sidebar.
 */
function addTermInspectorControls( BlockEdit ) {
	return ( props ) => {
		const { name, attributes, setAttributes } = props;

		// Early return if the block is not the Post Terms block.
		if ( name !== 'core/post-terms' ) {
			return <BlockEdit { ...props } />;
		}

		// Retrieve selected attributes from the block.
		const { isLink } = attributes;

		return (
			<>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __(
							'Settings',
							'vd-tag-block-extended'
						) }
					>
						<PanelRow>
							<ToggleControl
								label={ __(
									'Make term name a link',
									'vd-tag-block-extended'
								) }
								checked={ isLink }
								onChange={ () => {
									setAttributes( {
										isLink: ! isLink,
									} );
								} }
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
}

addFilter(
	'editor.BlockEdit',
	'vd-tag-block-extended/add-term-inspector-controls',
	addTermInspectorControls
);