/**
 * Conferences
 *
 * Registers gutenberg block
 * showing grid of conferences logos with links
 */

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

import {GutenBlock} from "../settings/guten-block";
import {GutenBlockSettings} from "../settings/guten-block-settings";

/**
 * Registers aa Gutenberg Block.
 */
registerBlockType( 'guten/cta', {
	title: __( 'CTA section' ),
	icon: 'shield',
	category: 'common',
	keywords: [ __( 'guten' ), __( 'cta' ), __( 'call to action' ), __( 'link section' ), ],
	attributes: {
		blockTitle: {
			type: 'string',
			default: null,
		},
		blockText: {
			type: 'string',
			default: null,
		},
		blockButtonText: {
			type: 'string',
			default: null,
		},
		blockUrl: {
			type: 'string',
			default: null,
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
			this.changeText = this.changeText.bind(this);
			this.changeButtonText = this.changeButtonText.bind(this);
			this.changeUrl = this.changeUrl.bind(this);
		}

		changeTitle(blockTitle) {
			this.props.setAttributes({ blockTitle });
		}

		changeText(blockText) {
			this.props.setAttributes({ blockText });
		}

		changeButtonText(blockButtonText) {
			this.props.setAttributes({ blockButtonText });
		}

		changeUrl(blockUrl) {
			this.props.setAttributes({ blockUrl });
		}

		render() {
			const {
				className,
				setAttributes,
				attributes: {
					blockTitle = '',
					blockText = '',
					blockButtonText = '',
					blockUrl = '',
				} = {}
			} = this.props;

			return (
				<div className={className}>
					<div class="guten-block-backend">
						<header>
							CTA
							<small>Displays simple Call To Action section</small>
						</header>
						<div>
							<TextControl
								label="Title"
								value={ blockTitle }
								onChange={ this.changeTitle }
							/>
						</div>
						<div>
							<TextControl
								label="Text"
								value={ blockText }
								onChange={ this.changeText }
							/>
						</div>
						<div>
							<TextControl
								label="Button Text"
								value={ blockButtonText }
								onChange={ this.changeButtonText }
							/>
						</div>
						<div>
							<TextControl
								label="Button URL"
								value={ blockUrl }
								onChange={ this.changeUrl }
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
	save: (props) => {
		return(
			<div>
				<section class={ 'widget cta ' + (props.attributes.blockDarkMode ? ' dark-mode' : '') + (props.attributes.blockPaddingTop != null ? ' ' + props.attributes.blockPaddingTop : '') + (props.attributes.blockPaddingBottom != null ? ' ' + props.attributes.blockPaddingBottom : '') + (props.attributes.blockOverlapTop ? ' overlap-top' : '') + (props.attributes.blockOverlapBottom ? ' overlap-bottom' : '') }>
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<h2>{props.attributes.blockTitle}</h2>
								{props.attributes.blockText}
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 aligncenter">
								<a class="btn" href={props.attributes.blockUrl}>{props.attributes.blockButtonText}</a>
							</div>
						</div>
					</div>
				</section>
			</div>
		);
	},
} );
