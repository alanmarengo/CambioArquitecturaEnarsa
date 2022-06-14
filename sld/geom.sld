<?xml version="1.0" encoding="UTF-8"?>
<StyledLayerDescriptor xmlns="http://www.opengis.net/sld" version="1.1.0" xmlns:se="http://www.opengis.net/se" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ogc="http://www.opengis.net/ogc" xmlns:xlink="http://www.w3.org/1999/xlink" xsi:schemaLocation="http://www.opengis.net/sld http://schemas.opengis.net/sld/1.1.0/StyledLayerDescriptor.xsd">
  <NamedLayer>
    <se:Name>[layer_name]</se:Name>
    <UserStyle>
      <se:Name>[layer_name]</se:Name>
      <se:FeatureTypeStyle>
        <Rule>
			<se:Name>[layer_name]</se:Name>
		   <!--<ogc:Filter>
			  <ogc:PropertyIsEqualTo>
				 <ogc:PropertyName>gtype</ogc:PropertyName>
				 <ogc:Literal>Point</ogc:Literal>
			  </ogc:PropertyIsEqualTo>
		   </ogc:Filter> -->
		   <PointSymbolizer>
			  <se:Graphic>
              <se:Mark>
                <se:WellKnownName>[symbol]</se:WellKnownName>
                <se:Fill>
                  <se:SvgParameter name="fill">[main_color]</se:SvgParameter>
                </se:Fill>
                <se:Stroke>
                  <se:SvgParameter name="stroke">[border_color]</se:SvgParameter>
                  <se:SvgParameter name="stroke-width">[border_size]</se:SvgParameter>
                </se:Stroke>
              </se:Mark>
              <se:Size>7</se:Size>
            </se:Graphic>
		   </PointSymbolizer>
		</Rule>
		<Rule>
			<se:Name>[layer_name]</se:Name>
		   <!--<ogc:Filter>
			  <ogc:PropertyIsEqualTo>
				 <ogc:PropertyName>gtype</ogc:PropertyName>
				 <ogc:Literal>Line</ogc:Literal>
			  </ogc:PropertyIsEqualTo>
		   </ogc:Filter> -->
		   <LineSymbolizer>
			  <se:Stroke>
              <se:SvgParameter name="stroke">[main_color]</se:SvgParameter>
              <!-- <se:SvgParameter name="stroke-width">[size]</se:SvgParameter> -->
              <se:SvgParameter name="stroke-linejoin">bevel</se:SvgParameter>
              <se:SvgParameter name="stroke-linecap">square</se:SvgParameter>
            </se:Stroke>
		   </LineSymbolizer>
		</Rule>
		<Rule>
			<se:Name>[layer_name]</se:Name>
		   <!--<ogc:Filter>
			  <ogc:PropertyIsEqualTo>
				 <ogc:PropertyName>gtype</ogc:PropertyName>
				 <ogc:Literal>Polygon</ogc:Literal>
			  </ogc:PropertyIsEqualTo>
		   </ogc:Filter>-->
		   <PolygonSymbolizer>
				<se:Fill>
					<se:SvgParameter name="fill">[main_color]</se:SvgParameter>
				</se:Fill>
            <se:Stroke>
              <se:SvgParameter name="stroke">[border_color]</se:SvgParameter>
              <se:SvgParameter name="stroke-width">[border_size]</se:SvgParameter>
              <se:SvgParameter name="stroke-linejoin">bevel</se:SvgParameter>
            </se:Stroke>
		   </PolygonSymbolizer>
		</Rule>
       </se:FeatureTypeStyle>
    </UserStyle>
  </NamedLayer>
</StyledLayerDescriptor>

