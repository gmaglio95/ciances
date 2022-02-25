import React from 'react';

import Gallery from '../gallery/Gallery';

const Works = () => {
    return (
        <section id="my-works" className="block spacer m-top-lg">
            <div className="wrapper-works">
                <h2> My works </h2>
            </div>
            {/* <NetSlider
				className='netslider_title_card'
				data={data}
			/> */}

            <Gallery  paddingBottomClass="" />
        </section>
    );
};

export default Works;
