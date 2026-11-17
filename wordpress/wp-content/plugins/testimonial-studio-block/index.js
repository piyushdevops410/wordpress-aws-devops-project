(function (blocks, blockEditor, components, element) {

var el = element.createElement;

var RichText = blockEditor.RichText;
var MediaUpload = blockEditor.MediaUpload;
var InspectorControls = blockEditor.InspectorControls;
var ColorPalette = blockEditor.ColorPalette;

var Button = components.Button;
var RangeControl = components.RangeControl;
var PanelBody = components.PanelBody;
var SelectControl = components.SelectControl;
var ToggleControl = components.ToggleControl;

blocks.registerBlockType('testimonial-studio/block',{

title:'Testimonial Studio',
icon:'format-quote',
category:'widgets',

attributes:{

testimonials:{type:'array',default:[]},

bgColor:{type:'string',default:'#f5f5f5'},
textColor:{type:'string',default:'#333'},
nameColor:{type:'string',default:'#000'},
companyColor:{type:'string',default:'#777'},

arrowColor:{type:'string',default:'#2d7ff9'},
dotColor:{type:'string',default:'#999'},
dotActiveColor:{type:'string',default:'#2d7ff9'},

avatarShape:{type:'string',default:'circle'},

layoutStyle:{type:'string',default:'card'},

autoplay:{type:'boolean',default:true},
speed:{type:'number',default:3000},

slidesDesktop:{type:'number',default:3},
slidesTablet:{type:'number',default:2},
slidesMobile:{type:'number',default:1}

},

edit:function(props){

var testimonials = props.attributes.testimonials;

/* Add testimonial */

function addTestimonial(){

var newTestimonials = testimonials.slice();

newTestimonials.push({
name:"",
company:"",
message:"",
image:"",
rating:5
});

props.setAttributes({testimonials:newTestimonials});

}

/* Update testimonial */

function updateTestimonial(value,index,field){

var newTestimonials = testimonials.slice();

newTestimonials[index][field]=value;

props.setAttributes({testimonials:newTestimonials});

}

/* Delete */

function deleteTestimonial(index){

var newTestimonials = testimonials.slice();

newTestimonials.splice(index,1);

props.setAttributes({testimonials:newTestimonials});

}

/* Duplicate */

function duplicateTestimonial(index){

var newTestimonials = testimonials.slice();

var duplicate = {...newTestimonials[index]};

newTestimonials.splice(index+1,0,duplicate);

props.setAttributes({testimonials:newTestimonials});

}

/* Move */

function moveUp(index){

if(index===0) return;

var newTestimonials = testimonials.slice();

var temp=newTestimonials[index-1];
newTestimonials[index-1]=newTestimonials[index];
newTestimonials[index]=temp;

props.setAttributes({testimonials:newTestimonials});

}

function moveDown(index){

if(index===testimonials.length-1) return;

var newTestimonials = testimonials.slice();

var temp=newTestimonials[index+1];
newTestimonials[index+1]=newTestimonials[index];
newTestimonials[index]=temp;

props.setAttributes({testimonials:newTestimonials});

}

return el("div",{style:{padding:"20px"}},

/* Inspector Controls */

el(InspectorControls,{},

/* Color Settings */

el(PanelBody,{title:"Color Settings",initialOpen:true},

el("p",{},"Background Color"),
el(ColorPalette,{
value:props.attributes.bgColor,
onChange:function(c){props.setAttributes({bgColor:c});}
}),

el("p",{},"Text Color"),
el(ColorPalette,{
value:props.attributes.textColor,
onChange:function(c){props.setAttributes({textColor:c});}
}),

el("p",{},"Name Color"),
el(ColorPalette,{
value:props.attributes.nameColor,
onChange:function(c){props.setAttributes({nameColor:c});}
}),

el("p",{},"Company Color"),
el(ColorPalette,{
value:props.attributes.companyColor,
onChange:function(c){props.setAttributes({companyColor:c});}
}),

el("p",{},"Arrow Color"),
el(ColorPalette,{
value:props.attributes.arrowColor,
onChange:function(c){props.setAttributes({arrowColor:c});}
}),

el("p",{},"Dot Color"),
el(ColorPalette,{
value:props.attributes.dotColor,
onChange:function(c){props.setAttributes({dotColor:c});}
}),

el("p",{},"Active Dot Color"),
el(ColorPalette,{
value:props.attributes.dotActiveColor,
onChange:function(c){props.setAttributes({dotActiveColor:c});}
})

),

/* Layout */

el(PanelBody,{title:"Layout Settings"},

el(SelectControl,{
label:"Layout Style",
value:props.attributes.layoutStyle,
options:[
{label:"Card",value:"card"},
{label:"Quote",value:"quote"},
{label:"Minimal",value:"minimal"}
],
onChange:function(v){props.setAttributes({layoutStyle:v});}
}),

el(SelectControl,{
label:"Avatar Shape",
value:props.attributes.avatarShape,
options:[
{label:"Circle",value:"circle"},
{label:"Rounded",value:"rounded"},
{label:"Square",value:"square"}
],
onChange:function(v){props.setAttributes({avatarShape:v});}
})

),

/* Slider Settings */

el(PanelBody,{title:"Slider Settings"},

el(ToggleControl,{
label:"Autoplay",
checked:props.attributes.autoplay,
onChange:function(v){props.setAttributes({autoplay:v});}
}),

el(RangeControl,{
label:"Autoplay Speed",
value:props.attributes.speed,
min:1000,
max:10000,
step:500,
onChange:function(v){props.setAttributes({speed:v});}
}),

el(RangeControl,{
label:"Slides Desktop",
value:props.attributes.slidesDesktop,
min:1,
max:4,
onChange:function(v){props.setAttributes({slidesDesktop:v});}
}),

el(RangeControl,{
label:"Slides Tablet",
value:props.attributes.slidesTablet,
min:1,
max:3,
onChange:function(v){props.setAttributes({slidesTablet:v});}
}),

el(RangeControl,{
label:"Slides Mobile",
value:props.attributes.slidesMobile,
min:1,
max:2,
onChange:function(v){props.setAttributes({slidesMobile:v});}
})

)

),

/* Testimonials */

testimonials.map(function(item,index){

return el("div",{className:"tsb-editor-box",key:index},

el(MediaUpload,{
onSelect:function(media){
updateTestimonial(media.url,index,"image");
},
allowedTypes:['image'],
render:function(obj){
return el(Button,{onClick:obj.open},
item.image
? el("img",{src:item.image,style:{width:"80px",borderRadius:"50%"}})
: "Upload Image"
);
}
}),

el(RichText,{
tagName:"p",
placeholder:"Testimonial text",
value:item.message,
onChange:function(v){updateTestimonial(v,index,"message");}
}),

el(RichText,{
tagName:"h4",
placeholder:"Client Name",
value:item.name,
onChange:function(v){updateTestimonial(v,index,"name");}
}),

el(RichText,{
tagName:"span",
placeholder:"Company",
value:item.company,
onChange:function(v){updateTestimonial(v,index,"company");}
}),

el(RangeControl,{
label:"Rating",
value:item.rating,
min:1,
max:5,
onChange:function(v){updateTestimonial(v,index,"rating");}
}),

el(Button,{onClick:function(){moveUp(index)}},"⬆ Move Up"),
el(Button,{onClick:function(){moveDown(index)}},"⬇ Move Down"),
el(Button,{onClick:function(){duplicateTestimonial(index)}},"Duplicate"),
el(Button,{isDestructive:true,onClick:function(){deleteTestimonial(index)}},"Delete")

);

}),

el(Button,{isPrimary:true,onClick:addTestimonial},"Add Testimonial")

);

},

save:function(props){

var testimonials = props.attributes.testimonials;

function renderStars(rating){

var stars=[];

for(var i=0;i<rating;i++){

stars.push(
el("span",{className:"tsb-star"},"★")
);

}

return stars;

}

return el("div",{
className:"tsb-slider swiper tsb-style-"+props.attributes.layoutStyle,
style:{
backgroundColor:props.attributes.bgColor,
"--cv-arrow-color":props.attributes.arrowColor,
"--cv-dot-color":props.attributes.dotColor,
"--cv-dot-active-color":props.attributes.dotActiveColor
},
"data-autoplay":props.attributes.autoplay,
"data-speed":props.attributes.speed,
"data-desktop":props.attributes.slidesDesktop,
"data-tablet":props.attributes.slidesTablet,
"data-mobile":props.attributes.slidesMobile
},

el("div",{className:"swiper-wrapper"},

testimonials.map(function(item,index){

return el("div",{className:"swiper-slide",key:index},

item.image && el("img",{
src:item.image,
className:"tsb-img tsb-avatar-"+props.attributes.avatarShape
}),

el("p",{style:{color:props.attributes.textColor}},item.message),

el("div",{className:"tsb-rating"},renderStars(item.rating)),

el("h4",{style:{color:props.attributes.nameColor}},item.name),

el("span",{style:{color:props.attributes.companyColor}},item.company)

);

})

),

el("div",{className:"swiper-pagination"}),
el("div",{className:"swiper-button-prev"}),
el("div",{className:"swiper-button-next"})

);

}

});

})(window.wp.blocks,window.wp.blockEditor,window.wp.components,window.wp.element);