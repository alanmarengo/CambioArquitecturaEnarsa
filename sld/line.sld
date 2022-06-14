<?xml version="1.0" encoding="UTF-8"?>
<StyledLayerDescriptor xmlns="http://www.opengis.net/sld" version="1.1.0" xmlns:se="http://www.opengis.net/se" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ogc="http://www.opengis.net/ogc" xmlns:xlink="http://www.w3.org/1999/xlink" xsi:schemaLocation="http://www.opengis.net/sld http://schemas.opengis.net/sld/1.1.0/StyledLayerDescriptor.xsd">
  <NamedLayer>
    <se:Name>[layer_name]</se:Name>
    <UserStyle>
      <se:Name>[layer_name]</se:Name>
      <se:FeatureTypeStyle>
        <se:Rule>
          <se:Name>[layer_name]</se:Name>
          <se:LineSymbolizer>
            <se:Stroke>
              <se:SvgParameter name="stroke">[main_color]</se:SvgParameter>
              <!-- <se:SvgParameter name="stroke-width">[size]</se:SvgParameter> -->
              <se:SvgParameter name="stroke-linejoin">bevel</se:SvgParameter>
              <se:SvgParameter name="stroke-linecap">square</se:SvgParameter>
            </se:Stroke>
          </se:LineSymbolizer>
        </se:Rule>
      </se:FeatureTypeStyle>
    </UserStyle>
  </NamedLayer>
</StyledLayerDescriptor>
