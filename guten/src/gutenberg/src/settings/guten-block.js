/**
 * Block settings
 *
 * Custom block settings
 * to be added to each custom gutenberg component
 */

import { __ } from '@wordpress/i18n';
import { Component } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, SelectControl, ToggleControl } from '@wordpress/components';
import Select from "react-select";

/**
 * Settings blocks.
 */
export class GutenBlock extends Component {
	constructor(props) {
		super(...arguments);
		this.props = props;

		this.changeDarkMode = this.changeDarkMode.bind(this);
		this.changeOverlapTop = this.changeOverlapTop.bind(this);
		this.changeOverlapBottom = this.changeOverlapBottom.bind(this);
		this.changePaddingTop = this.changePaddingTop.bind(this);
		this.changePaddingBottom = this.changePaddingBottom.bind(this);
	}

	changeDarkMode(blockDarkMode) {
		this.props.setAttributes({ blockDarkMode });
	}

	changeOverlapTop(blockOverlapTop) {
		this.props.setAttributes({ blockOverlapTop });
	}

	changeOverlapBottom(blockOverlapBottom) {
		this.props.setAttributes({ blockOverlapBottom });
	}

	changePaddingTop(blockPaddingTop) {
		this.props.setAttributes({ blockPaddingTop });
	}

	changePaddingBottom(blockPaddingBottom) {
		this.props.setAttributes({ blockPaddingBottom });
	}
}

