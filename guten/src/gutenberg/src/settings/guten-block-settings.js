/**
 * Block settings
 *
 * Suctom block settings
 * to be added to each custom gutenberg component
 */

import { __ } from '@wordpress/i18n';
import { Component } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, SelectControl, ToggleControl } from '@wordpress/components';

/**
 * Settings blocks.
 */
export const GutenBlockSettings = (props) => {
	const {
		blockDarkMode,
		changeDarkMode,
		blockOverlapTop,
		changeOverlapTop,
		blockOverlapBottom,
		changeOverlapBottom,
		blockPaddingTop,
		changePaddingTop,
		blockPaddingBottom,
		changePaddingBottom,
	} = props;

	return (
		<PanelBody
			title={ __( 'Settings', 'guten' ) }
		>
			<PanelRow>
				<ToggleControl
					label={ blockDarkMode ? 'Dark style' : 'Light style' }
					checked={ blockDarkMode }
					onChange={ changeDarkMode }
				/>
			</PanelRow>
			<PanelRow>
				<ToggleControl
					label={ blockOverlapTop ? 'Overlaps section above' : 'No top overlapping' }
					checked={ blockOverlapTop }
					onChange={ changeOverlapTop }
				/>
			</PanelRow>
			<PanelRow>
				<ToggleControl
					label={ blockOverlapBottom ? 'Overlaps section below' : 'No bottom overlapping' }
					checked={ blockOverlapBottom }
					onChange={ changeOverlapBottom }
				/>
			</PanelRow>
			<PanelRow>
				<SelectControl
					label="Padding top:"
					value={ blockPaddingTop }
					options={ [
						{ label: 'Small', value: null },
						{ label: 'Medium', value: 'padding-top-medium' },
						{ label: 'Large', value: 'padding-top-large' },
					] }
					onChange={ changePaddingTop }
				/>
			</PanelRow>
			<PanelRow>
				<SelectControl
					label="Padding bottom:"
					value={ blockPaddingBottom }
					options={ [
						{ label: 'Small', value: null },
						{ label: 'Medium', value: 'padding-bottom-medium' },
						{ label: 'Large', value: 'padding-bottom-large' },
					] }
					onChange={ changePaddingBottom }
				/>
			</PanelRow>
		</PanelBody>
	);
};
