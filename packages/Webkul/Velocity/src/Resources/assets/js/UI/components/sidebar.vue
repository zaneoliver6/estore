<template>
    <!-- categories list -->
    <nav
        :id="id"
        @mouseover="remainBar(id)"
        :class="`sidebar ${addClass ? addClass : ''}`"
        v-if="slicedCategories && slicedCategories.length > 0">

        <ul type="none">
            <li
                :key="categoryIndex"
                :id="`category-${category.id}`"
                class="category-content cursor-pointer"
                @mouseout="toggleSidebar(id, $event, 'mouseout')"
                @mouseover="toggleSidebar(id, $event, 'mouseover')"
                v-for="(category, categoryIndex) in slicedCategories">

                <a
                    :href="`${$root.baseUrl}/${category.slug}`"
                    :class="`category unset ${(category.children.length > 0) ? 'fw6' : ''}`">

                    <div
                        class="category-icon"
                        @mouseout="toggleSidebar(id, $event, 'mouseout')"
                        @mouseover="toggleSidebar(id, $event, 'mouseover')">

                        <img
                            v-if="category.category_icon_path"
                            :src="`${$root.baseUrl}/storage/${category.category_icon_path}`"
                            width="20" height="20" />
                    </div>

                    <span class="category-title">{{ category['name'] }}</span>

                    <i
                        class="rango-arrow-right pr15 pull-right"
                        @mouseout="toggleSidebar(id, $event, 'mouseout')"
                        @mouseover="toggleSidebar(id, $event, 'mouseover')"
                        v-if="category.children.length && category.children.length > 0">
                    </i>
                </a>

                <div
                    class="sub-category-container"
                    v-if="category.children.length && category.children.length > 0">

                    <div
                        @mouseout="toggleSidebar(id, $event, 'mouseout')"
                        @mouseover="remainBar(`sidebar-level-${sidebarLevel+categoryIndex}`)"
                        :class="`sub-categories sub-category-${sidebarLevel+categoryIndex} cursor-default`">

                        <nav
                            class="sidebar"
                            :id="`sidebar-level-${sidebarLevel+categoryIndex}`"
                            @mouseover="remainBar(`sidebar-level-${sidebarLevel+categoryIndex}`)">
                            <div class="sub-category-panel" 
                                 :key="`${subCategoryIndex}-${categoryIndex}`" 
                                 v-for="(subCategory, subCategoryIndex) in category.children"> 
                                <!-- <a href="#" class="accordion" @click="togglePanel($event, subCategory)"> {{ subCategory.name }}</a> -->
                                <span>
                                    <a
                                        :id="`sidebar-level-link-2-${subCategoryIndex}`"
                                        @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                        :href="`${$root.baseUrl}/${category.slug}/${subCategory.slug}`"
                                        :class="`accordion category sub-category unset ${(subCategory.children.length > 0) ? 'fw6' : ''}`">

                                        <div
                                            class="category-icon"
                                            @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                            @mouseover="toggleSidebar(id, $event, 'mouseover')">

                                            <img
                                                v-if="subCategory.category_icon_path"
                                                :src="`${$root.baseUrl}/storage/${subCategory.category_icon_path}`" />
                                        </div>
                                        <span class="category-title">{{ subCategory['name'] }}</span>
                                        <!-- <div class="button-container pull-right"><button class="panel-button" @click="togglePanel($event, subCategory)"> + </button></div> -->
                                        <i 
                                            class="material-icons pull-right text-dark expand-icon" 
                                            :id="`icon-id-${subCategory.id}`"
                                            @click="togglePanel($event, subCategory)"
                                            v-if="subCategory.children.length && subCategory.children.length > 0">
                                            add_circle
                                        </i>
                                    </a>
                                </span>
                                <div class="accordion-panel" :id="`accordion-panel-${subCategory.id}`" v-if="subCategory.children.length && subCategory.children.length > 0">
                                    <ul type="none" class="nested">
                                        <li
                                            :key="`${childSubCategoryIndex}-${subCategoryIndex}-${categoryIndex}`"
                                            v-for="(childSubCategory, childSubCategoryIndex) in subCategory.children">

                                            <a
                                                :id="`sidebar-level-link-3-${childSubCategoryIndex}`"
                                                :class="`category unset ${(subCategory.children.length > 0) ? 'fw6' : ''}`"
                                                :href="`${$root.baseUrl}/${category.slug}/${subCategory.slug}/${childSubCategory.slug}`">
                                                <span class="category-title">{{ childSubCategory.name }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- <ul type="none">
                                <li
                                    :key="`${subCategoryIndex}-${categoryIndex}`"
                                    v-for="(subCategory, subCategoryIndex) in category.children">

                                    <a
                                        :id="`sidebar-level-link-2-${subCategoryIndex}`"
                                        @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                        :href="`${$root.baseUrl}/${category.slug}/${subCategory.slug}`"
                                        :class="`category sub-category unset ${(subCategory.children.length > 0) ? 'fw6' : ''}`">

                                        <div
                                            class="category-icon"
                                            @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                            @mouseover="toggleSidebar(id, $event, 'mouseover')">

                                            <img
                                                v-if="subCategory.category_icon_path"
                                                :src="`${$root.baseUrl}/storage/${subCategory.category_icon_path}`" />
                                        </div>
                                        <span class="category-title">{{ subCategory['name'] }}</span>
                                    </a>

                                    <ul type="none" class="nested">
                                        <li
                                            :key="`${childSubCategoryIndex}-${subCategoryIndex}-${categoryIndex}`"
                                            v-for="(childSubCategory, childSubCategoryIndex) in subCategory.children">

                                            <a
                                                :id="`sidebar-level-link-3-${childSubCategoryIndex}`"
                                                :class="`category unset ${(subCategory.children.length > 0) ? 'fw6' : ''}`"
                                                :href="`${$root.baseUrl}/${category.slug}/${subCategory.slug}/${childSubCategory.slug}`">
                                                <span class="category-title">{{ childSubCategory.name }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> -->
                        </nav>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script type="text/javascript">
    export default {
        props: [
            'id',
            'addClass',
            'parentSlug',
            'mainSidebar',
            'categoryCount'
        ],

        data: function () {
            return {
                slicedCategories: [],
                sidebarLevel: Math.floor(Math.random() * 1000),
            }
        },

        watch: {
            '$root.sharedRootCategories': function (categories) {
                this.formatCategories(categories);
                this.addExtraProp(categories);
            }
        },

        methods: {
            remainBar: function (id) {
                let sidebar = $(`#${id}`);
                if (sidebar && sidebar.length > 0) {
                    sidebar.show();

                    let actualId = id.replace('sidebar-level-', '');

                    let sidebarContainer = sidebar.closest(`.sub-category-${actualId}`)
                    if (sidebarContainer && sidebarContainer.length > 0) {
                        sidebarContainer.show();
                    }

                }
            },

            formatCategories: function (categories) {
                let slicedCategories = categories;
                let categoryCount = this.categoryCount ? this.categoryCount : 9;

                if (
                    slicedCategories
                    && slicedCategories.length > categoryCount
                ) {
                    slicedCategories = categories.slice(0, categoryCount);
                }

                if (this.parentSlug)
                    slicedCategories['parentSlug'] = this.parentSlug;

                this.slicedCategories = slicedCategories;
            },

            togglePanel: function (e, subCategory) {
                e.preventDefault();
                console.log('toggledBUtton');
                console.log(e);
                
                let selectedExpandButton = e.target;
                console.log(selectedExpandButton.innerHTML);
                selectedExpandButton.innerHTML = 'add_circle';

                subCategory.active = !subCategory.active;
                let panels = $('.sub-category-panel .accordion-panel');
                console.log(panels);
                panels.hide();

                let selectedPanel = $('.sub-category-panel .accordion-panel#accordion-panel-' + subCategory.id);
                console.log(selectedPanel);
                
                if (subCategory.active) {
                    selectedPanel.show();
                    console.log('in if');
                    selectedExpandButton.innerHTML = 'remove_circle';
                }
            },
            addExtraProp: function (categories) {
                categories.forEach( category => {
                    if (category.children.length && category.children.length > 0) {
                        category.children.forEach(subCategory => {
                            subCategory.active = false;
                            subCategory.btnIcon = 'add_circle';
                        });
                    }
                });
            },
        },
    }
</script>

<style scoped>
.accordion {
  outline: none;
  top: -1px;
  position: relative;
  font-weight: 600;
  transition: 0.4s;
  background-color: white;
}

.active, .accordion:hover {
  background-color: #ccc; 
}

.accordion-panel {
  /* padding: 0 18px; */
  display: none;
  background-color: white;
  overflow: hidden;
}

.expand-icon {
    padding-right: 1rem;
    font-size: 1.7rem;
}

li a#sidebar-leve-link-* {
    font-weight: 100;
}
</style>