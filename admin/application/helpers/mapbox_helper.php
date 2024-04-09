<?php
function get_mapbox_key() {
  // Qu4r2200*
  $keys = [
    "pk.eyJ1IjoidmNtYXBib3gxMCIsImEiOiJjbHVzY3Fwb2wwYXZxMmpvOWc3Y3Q0c3p4In0.kJr3Q8WrAli2FN2AccFIvA", // vcmapbox10
    "pk.eyJ1IjoidmNtYXBib3gxMSIsImEiOiJjbHVzY3kweGcwaDBmMm1yejNyNjB0d2F0In0.6kvfxE3UqRsJXhKaJ8tEKg", // vcmapbox11
    "pk.eyJ1IjoidmNtYXBib3gxMiIsImEiOiJjbHVzZDBtYnIwaDE4Mm1yemt0bnp6Njl2In0.sES5KGdFvIRd_DGscR0_Sw", // vcmapbox12
    "pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A", // vcmapbox14
    //"", // vcmapbox15
    //"", // vcmapbox16
    //"", // vcmapbox17
    //"", // vcmapbox18
    //"", // vcmapbox19
    //"", // vcmapbox20
  ];
  $indice_aleatorio = array_rand($keys);
  return $keys[$indice_aleatorio];
}
?>