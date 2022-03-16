import React, { Component } from 'react';
import Isotope from 'isotope-layout';
import ImagesLoaded from 'imagesloaded';
import PropTypes from 'prop-types';

class Gallery extends Component {
    constructor(props) {
        super(props);
        this.onFilterChange = this.onFilterChange.bind(this);

        this.state = {
            selected: 0,
            list: [],
            works: []
        };
    }

    handleClick(i, e) {
        e.preventDefault();

        this.setState({
            selected: i
        });

        return false
    }

    onFilterChange = (newFilter) => {
        var gallery_items_name = this.grid;
        var gallery_item_name = '.gallery-item';

        if (this.iso === undefined) {
            this.iso = new Isotope(gallery_items_name, {
                itemSelector: gallery_item_name,
                masonry: {
                    horizontalOrder: true
                }
            });
        }

        if (newFilter === '*') {
            this.iso.arrange({ filter: `*` });

        } else {
            this.iso.arrange({ filter: `.${newFilter}` });
        }
    };

    componentDidMount() {
        var gallery_items_name = this.grid;
        var gallery_item_name = '.gallery-item';

        let myHeaders = new Headers();
        myHeaders.append('pragma', 'no-cache');
        myHeaders.append('cache-control', 'no-cache');
        
        let myInit = {
          method: 'GET',
          headers: myHeaders,
        };

        fetch(process.env.PUBLIC_URL + "/assets/content/gallery/galleryMenu.json",myInit).then(response => {
            return response.json();
        }).then(menu => {
            fetch(process.env.PUBLIC_URL + "/assets/content/gallery/galleryItems.json",myInit).then(response => {
                return response.json();
            }).then(items => {
                this.setState({ list: menu, works: items});
                var iso = new Isotope(gallery_items_name, {
                    itemSelector: gallery_item_name,
                    masonry: {
                        horizontalOrder: true
                    }
                });

                var imgLoad = new ImagesLoaded(gallery_items_name);
                var zhis = this;
                imgLoad.on('progress', function (instance, image) {
                    iso.layout();
                    zhis.onFilterChange(menu[0].filter);
                });
            });
        });
    }

    render() {
        const listCount = this.state.list.length - 1;

        return (
            <div className="gallery">
                <div className="wrapper">
                    <ul className="gallery-filter list-unstyled no-space">
                        {this.state.list.map((item, key) => (
                            <React.Fragment key={key}>
                                <li>
                                    <a href="#my-works"
                                        title={item.title}
                                        className={"btn btn-link transform-scale-h click work-text-size" + (key === this.state.selected ? ' active' : '')}
                                        data-filter={item.filter}
                                        onClick={(event) => {
                                            this.onFilterChange(item.filter);
                                            this.handleClick(key, event)
                                        }}>
                                        {item.title}
                                    </a>
                                </li>

                                {key !== listCount ?
                                    <li>
                                        <span className="btn btn-link">-</span>
                                    </li>
                                    : ""
                                }
                            </React.Fragment>
                        ))}
                    </ul>
                </div>
                <div className={"gallery-item-wrapper" + this.props.paddingBottomClass} >
                    <div className="gallery-items" ref={(c) => this.grid = c}>
                        {this.state.works.map((item, key) => {
                            return (
                                <a key={key} title={item.title} className={"gallery-item active " + item.category} target={item.otherPage ? '_blank' : null} href={item.otherPage ? item.link : process.env.PUBLIC_URL + item.link + "/" + item.id}>
                                    <div className="img object-fit">
                                        <div className="object-fit-contain">
                                            <img src={process.env.PUBLIC_URL + item.imgLink} alt={process.env.PUBLIC_URL + item.title} />
                                        </div>
                                    </div>
                                </a>
                            );
                        })}
                    </div>
                </div>

                {this.props.seeMore ?
                    <div className="text-center no-space">
                        <a title="See more" className="btn btn-link border-0 p-0 transform-scale-h" href={process.env.PUBLIC_URL + "/works"}>See more<i className="icon-c icon-arrow-right" /></a>
                    </div>
                    : ""
                }
            </div>
        );
    }
}

Gallery.propTypes = {
    seeMore: PropTypes.string,
    paddingBottomClass: PropTypes.string
};

export default Gallery;
