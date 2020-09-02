/**
 * Post Listing
 *
 * Registers gutenberg block
 * showing post listing section with sidebar
 */

import { __ } from '@wordpress/i18n';
import { Component } from '@wordpress/element';
import { registerBlockType } from '@wordpress/blocks';
import { TextControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { GutenBlock } from '../settings/guten-block.js';
import { GutenBlockSettings } from '../settings/guten-block-settings.js';

//import ServerSideRender from '@wordpress/server-side-render';

/**
 * Registers aa Gutenberg Block.
 */
registerBlockType( 'guten/post-listing', {
	title: __( 'Post Listing' ),
	icon: 'shield',
	category: 'common',
	keywords: [ __( 'guten' ), __( 'listing' ), __( 'post' ), __( 'posts' ), __( 'blog' ), ],
	attributes: {
		blockTitle: {
			type: 'string'
		},
		blockDarkMode: {
			type: 'boolean',
			default: false,
		},
		blockOverlapTop: {
			type: 'boolean',
			default: false,
		},
		blockOverlapBottom: {
			type: 'boolean',
			default: false,
		},
		blockPaddingTop: {
			type: 'text',
			default: null,
		},
		blockPaddingBottom: {
			type: 'text',
			default: null,
		},
	},

	/**
	 * Edit function
	 * backend view
	 */
	edit: class extends GutenBlock {
		constructor(props) {
			super(...arguments);
			this.props = props;

			this.changeTitle = this.changeTitle.bind(this);
		}

		changeTitle(blockTitle) {
			this.props.setAttributes({ blockTitle });
		}

		render() {
			const {
				className,
				attributes: {
					blockTitle = '',
				} = {}
			} = this.props;

			return (
				<div className={className}>
					<div class="guten-block-backend">
						<header>
							Post Listing
							<small>Displays post listing with sidebar</small>
						</header>
						<div>
							<TextControl
								label="Title"
								value={ blockTitle }
								onChange={ this.changeTitle }
							/>
						</div>
					</div>
					<InspectorControls>
						<GutenBlockSettings
							blockDarkMode={ this.props.attributes.blockDarkMode }
							changeDarkMode={ this.changeDarkMode }
							blockOverlapTop={ this.props.attributes.blockOverlapTop }
							changeOverlapTop={ this.changeOverlapTop }
							blockOverlapBottom={ this.props.attributes.blockOverlapBottom }
							changeOverlapBottom={ this.changeOverlapBottom }
							blockPaddingTop={ this.props.attributes.blockPaddingTop }
							changePaddingTop={ this.changePaddingTop }
							blockPaddingBottom={ this.props.attributes.blockPaddingBottom }
							changePaddingBottom={ this.changePaddingBottom }
						/>
					</InspectorControls>
				</div>
			);
		}
	},

	/**
	 * Save function
	 * frontend view
	 */
	save: () => {
		return null;
	},
} );
