<template>
    <!--
    SPDX-FileCopyrightText: Brian Rogers <captbrogers@gmail.com>
    SPDX-License-Identifier: AGPL-3.0-or-later
    -->
    <div id="content" class="app-cardkeep">
        <AppNavigation>
            <AppNavigationNew v-if="!loading" :text="t('cardkeep', 'New note')" :disabled="false" button-id="new-cardkeep-button" button-class="icon-add" @click="newNote"></AppNavigationNew>
            <ul>
                <AppNavigationItem v-for="note in notes" :key="note.id" :title="note.title ? note.title : t('cardkeep', 'New note')" :class="{active: currentNoteId === note.id}" @click="openNote(note)">
                    <template slot="actions">
                        <ActionButton v-if="note.id === -1" icon="icon-close" @click="cancelNewNote(note)">{{ t('cardkeep', 'Cancel note creation') }}</ActionButton>
                        <ActionButton v-else icon="icon-delete" @click="deleteNote(note)">{{ t('cardkeep', 'Delete note') }}</ActionButton>
                    </template>
                </AppNavigationItem>
            </ul>
        </AppNavigation>
        <AppContent>
            <div class="appContent_container">
                <div class="topNav_container">
                    <div class="search-form_container">
                        <form  accept-charset="utf-8" class="search-form">
                            <input type="search" id="cardkeep-search" name="cardkeep-search" class="cardkeep-search-input" :placeholder="t('cardkeep', 'Search your notes')">
                        </form>
                    </div>
                </div>
                <div class="cards_container">
                    <div class="note_card" v-for="note in notes" :key="note.id">
                        <div class="card_header">{{ note.title }}</div>
                        <div class="card_body">{{ note.content }}</div>
                        <div class="card_footer">
                            <button type="button" class="ck-icon-button button-vue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet">
                                    <title>{{ t('cardkeep', 'Add reminder') }}</title>
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    <path d="M2 8c0-2.2.7-4.3 2-6"></path>
                                    <path d="M22 8a10 10 0 0 0-2-6"></path>
                                </svg>
                            </button>
                            <button type="button" class="ck-icon-button button-vue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet">
                                    <title>{{ t('cardkeep', 'Color options') }}</title>
                                    <circle cx="13.5" cy="6.5" r=".5"></circle>
                                    <circle cx="17.5" cy="10.5" r=".5"></circle>
                                    <circle cx="8.5" cy="7.5" r=".5"></circle>
                                    <circle cx="6.5" cy="12.5" r=".5"></circle>
                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
                                </svg>
                            </button>
                            <button type="button" class="ck-icon-button button-vue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet">
                                    <title>{{ t('cardkeep', 'Add image') }}</title>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                                    <line x1="16" y1="5" x2="22" y2="5"></line>
                                    <line x1="19" y1="2" x2="19" y2="8"></line>
                                    <circle cx="9" cy="9" r="2"></circle>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                </svg>
                            </button>
                            <button type="button" class="ck-icon-button button-vue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet">
                                    <title>{{ t('cardkeep', 'Archive note') }}</title>
                                    <rect x="2" y="4" width="20" height="5" rx="2"></rect>
                                    <path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"></path>
                                    <path d="M10 13h4"></path>
                                </svg>
                            </button>
                            <button type="button" class="ck-icon-button button-vue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet">
                                    <title>{{ t('cardkeep', 'More options') }}</title>
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentNote">
                <input ref="title" v-model="currentNote.title" type="text" :disabled="updating">
                <textarea ref="content" v-model="currentNote.content" :disabled="updating" />
                <input type="button" class="primary" :value="t('cardkeep', 'Save')" :disabled="updating || !savePossible" @click="saveNote">
            </div>
            <div v-else id="emptycontent">
                <div class="icon-file"></div>
                <h2>{{ t('cardkeep', 'Create a note to get started') }}</h2>
            </div>
        </AppContent>
    </div>
</template>

<script>
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationNew from '@nextcloud/vue/dist/Components/AppNavigationNew'

import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

export default {
    name: 'App',
    components: {
        ActionButton,
        AppContent,
        AppNavigation,
        AppNavigationItem,
        AppNavigationNew,
    },
    data() {
        return {
            notes: [],
            currentNoteId: null,
            updating: false,
            loading: true,
        }
    },
    computed: {
        /**
         * Return the currently selected note object
         * @returns {Object|null}
         */
        currentNote() {
            if (this.currentNoteId === null) {
                return null
            }
            return this.notes.find((note) => note.id === this.currentNoteId)
        },

        /**
         * Returns true if a note is selected and its title is not empty
         * @returns {Boolean}
         */
        savePossible() {
            return this.currentNote && this.currentNote.title !== ''
        },
    },
    /**
     * Fetch list of notes when the component is loaded
     */
    async mounted() {
        try {
            const response = await axios.get(generateUrl('/apps/cardkeep/notes'))
            this.notes = response.data
        } catch (e) {
            console.error(e)
            showError(t('notestutorial', 'Could not fetch notes'))
        }
        this.loading = false
    },

    methods: {
        /**
         * Create a new note and focus the note content field automatically
         * @param {Object} note Note object
         */
        openNote(note) {
            if (this.updating) {
                return
            }
            this.currentNoteId = note.id
            this.$nextTick(() => {
                this.$refs.content.focus()
            })
        },
        /**
         * Action tiggered when clicking the save button
         * create a new note or save
         */
        saveNote() {
            if (this.currentNoteId === -1) {
                this.createNote(this.currentNote)
            } else {
                this.updateNote(this.currentNote)
            }
        },
        /**
         * Create a new note and focus the note content field automatically
         * The note is not yet saved, therefore an id of -1 is used until it
         * has been persisted in the backend
         */
        newNote() {
            if (this.currentNoteId !== -1) {
                this.currentNoteId = -1
                this.notes.push({
                    id: -1,
                    title: '',
                    content: '',
                })
                this.$nextTick(() => {
                    this.$refs.title.focus()
                })
            }
        },
        /**
         * Abort creating a new note
         */
        cancelNewNote() {
            this.notes.splice(this.notes.findIndex((note) => note.id === -1), 1)
            this.currentNoteId = null
        },
        /**
         * Create a new note by sending the information to the server
         * @param {Object} note Note object
         */
        async createNote(note) {
            this.updating = true
            try {
                const response = await axios.post(generateUrl('/apps/cardkeep/notes'), note)
                const index = this.notes.findIndex((match) => match.id === this.currentNoteId)
                this.$set(this.notes, index, response.data)
                this.currentNoteId = response.data.id
            } catch (e) {
                console.error(e)
                showError(t('notestutorial', 'Could not create the note'))
            }
            this.updating = false
        },
        /**
         * Update an existing note on the server
         * @param {Object} note Note object
         */
        async updateNote(note) {
            this.updating = true
            try {
                await axios.put(generateUrl(`/apps/cardkeep/notes/${note.id}`), note)
            } catch (e) {
                console.error(e)
                showError(t('notestutorial', 'Could not update the note'))
            }
            this.updating = false
        },
        /**
         * Delete a note, remove it from the frontend and show a hint
         * @param {Object} note Note object
         */
        async deleteNote(note) {
            try {
                await axios.delete(generateUrl(`/apps/cardkeep/notes/${note.id}`))
                this.notes.splice(this.notes.indexOf(note), 1)
                if (this.currentNoteId === note.id) {
                    this.currentNoteId = null
                }
                showSuccess(t('cardkeep', 'Note deleted'))
            } catch (e) {
                console.error(e)
                showError(t('cardkeep', 'Could not delete the note'))
            }
        },
    },
}
</script>
<style scoped>
    #app-content > div {
        width: 100%;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    input[type='text'] {
        width: 100%;
    }

    textarea {
        flex-grow: 1;
        width: 100%;
    }

    .appContent_container {
        position: relative;
    }

    @media only screen and (min-width: 641px) and (max-width: 1366px) {
        .appContent_container {
            max-width: 1050px;
        }

        .cardkeep-search-input {
            width: 360px;
        }
    }

    @media only screen and (min-width: 1367px) and (max-width: 1920px) {
        .appContent_container {
            /*max-width: 1604px;*/
        }

        .cardkeep-search-input {
            width: 500px;
        }
    }

    .topNav_container {
        border-top-right-radius: var(--body-container-radius);
        height: 65px;
        margin-left: 50px;
        margin-right: 50px;
        max-width: 1554px;
        width: 100%;
    }

    .search-form_container {
        display: flex;
        align-items: center;
        height: 65px;
    }

    .search-form {}

    .cards_container {
        display: grid;
        grid-template-rows: max-content;
        gap: 2rem;
        padding: 25px 50px;
    }

    .note_card {
        display: flex;
        flex-direction: column;
        background-color: hsl(0, 0%, 100%);
        border-radius: 8px;
        border: 1px solid hsl(0, 0%, 87.8%);
        transition-duration: 0.218s;
        transition-property: opacity,transform;
        max-width: 250px;
    }

    .note_card:hover {
        box-shadow: 0 1px 2px 0 hsla(206, 5.5%, 24.9%, 0.3), 0 1px 3px 1px hsla(206, 5.5%, 24.9%, 0.15);
    }

    .note_card .card_header {
        border-bottom: 1px solid hsl(0, 0%, 87.8%);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .note_card .card_body {
        padding: 0.5rem 1rem;
    }

    .note_card .card_footer {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        border-top: 1px solid hsl(0, 0%, 87.8%);
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .note_card .card_footer .ck-icon-button {
        transition-duration: 0.218s;
        transition-property: opacity,transform;
        opacity: 0;
        border: none;
        background: transparent;
        padding: 5px 3px;
        cursor: pointer;
    }

    .note_card:hover .card_footer .ck-icon-button {
        opacity: 1;
    }
</style>
