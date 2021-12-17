import React from 'react';

import Gallery from '../gallery/Gallery';

const Works = () => {
    return (
        <section id="my-works" className="block spacer m-top-xl">
            <div className="wrapper-works">
                <h2>
                    <a title="My works" className="transform-scale-h" href={process.env.PUBLIC_URL + "/works"}>My <span className="line">works</span></a>
                </h2>
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
