import * as THREE from 'three';

import {
    OrbitControls
} from 'three/examples/jsm/controls/OrbitControls.js';

import {
    createOdontogramArch,
    createOdontogramGumArch
} from './odontogram-model';

const ADULT_UPPER_RIGHT =
    [18, 17, 16, 15, 14, 13, 12, 11];

const ADULT_UPPER_LEFT =
    [21, 22, 23, 24, 25, 26, 27, 28];

const ADULT_LOWER_RIGHT =
    [48, 47, 46, 45, 44, 43, 42, 41];

const ADULT_LOWER_LEFT =
    [31, 32, 33, 34, 35, 36, 37, 38];

const ADULT_UPPER = [
    ...ADULT_UPPER_RIGHT,
    ...ADULT_UPPER_LEFT
];

const ADULT_LOWER = [
    ...ADULT_LOWER_RIGHT,
    ...ADULT_LOWER_LEFT
];

const activeOdontogramStates =
    new Set();

function normalizeOdontogramData(data) {
    return Array.isArray(data)
        ? data
        : Object.values(data || {});
}

function getOdontogramRecord(
    data,
    tooth
) {
    return (
        data.find(
            item =>
                Number(item?.tooth) ===
                Number(tooth)
        ) || null
    );
}

export function createOdontogramThreeScene({
    container,
    data = [],
    mode = 'preview',
    onToothClick = null,
    onToothHover = null,
    onReady = null
}) {
    if (!container) {
        return null;
    }

    const width =
        container.clientWidth || 700;

    const height =
        container.clientHeight || 480;

    const scene =
        new THREE.Scene();

    const camera =
        new THREE.PerspectiveCamera(
            40,
            width / height,
            0.1,
            1000
        );

    camera.position.set(
        0,
        1.2,
        14
    );

    const renderer =
        new THREE.WebGLRenderer({
            antialias: true,
            alpha: false
        });

    renderer.setPixelRatio(
        Math.min(
            window.devicePixelRatio || 1,
            2
        )
    );

    renderer.setSize(
        width,
        height,
        false
    );

    renderer.shadowMap.enabled =
        true;

    renderer.shadowMap.type =
        THREE.PCFSoftShadowMap;

    container
        .querySelectorAll('canvas')
        .forEach(canvas => canvas.remove());

    container.appendChild(
        renderer.domElement
    );

    const controls =
        new OrbitControls(
            camera,
            renderer.domElement
        );

    controls.enableDamping = true;
    controls.dampingFactor = 0.07;
    controls.minDistance = 2.2;
    controls.maxDistance = 30;
    controls.maxPolarAngle =
        Math.PI / 1.8;

    controls.target.set(
        0,
        0,
        0
    );

    controls.update();

    const teethMeshes = [];

    const state = {
        container,
        mode,

        scene,
        camera,
        renderer,
        controls,

        teethMeshes,

        raycaster:
            new THREE.Raycaster(),

        pointer:
            new THREE.Vector2(),

        data:
            normalizeOdontogramData(
                data
            ),

        selectedTooth: null,
        selectedMesh: null,

        onToothClick,
        onToothHover,

        initialCameraPosition:
            camera.position.clone(),

        initialControlsTarget:
            controls.target.clone(),

        cameraAnimationFrame: null,
        animationFrame: null
    };

    addOdontogramLights(
        state
    );

    buildOdontogramModel(
        state
    );

    bindOdontogramPointerEvents(
        state
    );

    syncOdontogramThreeTheme(
        state
    );

    startOdontogramAnimation(
        state
    );

    activeOdontogramStates.add(
        state
    );

    updateOdontogramThreeScene(
        state,
        data
    );

    onReady?.(
        state
    );

    return state;
}

function buildOdontogramModel(
    state
) {
    createOdontogramGumArch({
        scene:
            state.scene,

        yPosition:
            1.30,

        isUpper:
            true
    });

    createOdontogramGumArch({
        scene:
            state.scene,

        yPosition:
            -1.30,

        isUpper:
            false
    });

    createOdontogramArch({
        scene:
            state.scene,

        teethArray:
            ADULT_UPPER,

        yPosition:
            0.95,

        isUpper:
            true,

        teethMeshes:
            state.teethMeshes
    });

    createOdontogramArch({
        scene:
            state.scene,

        teethArray:
            ADULT_LOWER,

        yPosition:
            -0.95,

        isUpper:
            false,

        teethMeshes:
            state.teethMeshes
    });
}

function addOdontogramLights(
    state
) {
    const ambientLight =
        new THREE.AmbientLight(
            0xffffff,
            0.75
        );

    const keyLight =
        new THREE.DirectionalLight(
            0xffffff,
            0.8
        );

    keyLight.position.set(
        10,
        15,
        10
    );

    keyLight.castShadow = true;

    keyLight.shadow.mapSize.width =
        1024;

    keyLight.shadow.mapSize.height =
        1024;

    const backLight =
        new THREE.DirectionalLight(
            0xffffff,
            0.45
        );

    backLight.position.set(
        -10,
        5,
        -10
    );

    const fillLight =
        new THREE.DirectionalLight(
            0xffffff,
            0.35
        );

    fillLight.position.set(
        0,
        8,
        12
    );

    state.scene.add(
        ambientLight,
        keyLight,
        backLight,
        fillLight
    );
}

export function resizeOdontogramThreeScene(
    state
) {
    if (
        !state?.renderer ||
        !state?.camera ||
        !state?.container
    ) {
        return;
    }

    const width =
        state.container
            .clientWidth ||
        700;

    const height =
        state.container
            .clientHeight ||
        480;

    if (
        width < 10 ||
        height < 10
    ) {
        return;
    }

    state.camera.aspect =
        width / height;

    state.camera
        .updateProjectionMatrix();

    state.renderer.setSize(
        width,
        height,
        false
    );
}

function easeInOutCubic(value) {
    return value < 0.5
        ? 4 * value * value * value
        : 1 - Math.pow(-2 * value + 2, 3) / 2;
}

function animateOdontogramCamera(
    state,
    targetPosition,
    targetLookAt,
    duration = 650
) {
    if (
        !state?.camera ||
        !state?.controls
    ) {
        return;
    }

    if (
        state.cameraAnimationFrame
    ) {
        cancelAnimationFrame(
            state.cameraAnimationFrame
        );
    }

    const startPosition =
        state.camera
            .position
            .clone();

    const startTarget =
        state.controls
            .target
            .clone();

    const startTime =
        performance.now();

    const step =
        now => {
            const progress =
                Math.min(
                    (
                        now -
                        startTime
                    ) /
                    duration,
                    1
                );

            const eased =
                easeInOutCubic(
                    progress
                );

            state.camera.position
                .lerpVectors(
                    startPosition,
                    targetPosition,
                    eased
                );

            state.controls.target
                .lerpVectors(
                    startTarget,
                    targetLookAt,
                    eased
                );

            state.controls.update();

            if (progress < 1) {
                state.cameraAnimationFrame =
                    requestAnimationFrame(
                        step
                    );
            } else {
                state.cameraAnimationFrame =
                    null;
            }
        };

    state.cameraAnimationFrame =
        requestAnimationFrame(
            step
        );
}

export function focusOdontogramThreeTooth(
    state,
    mesh
) {
    if (
        !state ||
        !mesh
    ) {
        return;
    }

    const toothPosition =
        new THREE.Vector3();

    mesh.getWorldPosition(
        toothPosition
    );

    const toothNumber =
        Number(
            mesh.userData.tooth
        );

    const isUpper =
        ADULT_UPPER.includes(
            toothNumber
        );

    const cameraOffset =
        isUpper
            ? new THREE.Vector3(
                0,
                -2.2,
                4.2
            )
            : new THREE.Vector3(
                0,
                2.4,
                4.2
            );

    const lookAtOffset =
        isUpper
            ? new THREE.Vector3(
                0,
                -0.15,
                0
            )
            : new THREE.Vector3(
                0,
                0.15,
                0
            );

    animateOdontogramCamera(
        state,

        toothPosition
            .clone()
            .add(
                cameraOffset
            ),

        toothPosition
            .clone()
            .add(
                lookAtOffset
            ),

        700
    );
}

export function resetOdontogramThreeCamera(
    state
) {
    if (!state) {
        return;
    }

    animateOdontogramCamera(
        state,

        state
            .initialCameraPosition
            .clone(),

        state
            .initialControlsTarget
            .clone(),

        700
    );
}

export function getOdontogramThreeToothMesh(
    state,
    tooth
) {
    if (!state) {
        return null;
    }

    return (
        state.teethMeshes.find(
            mesh =>
                Number(
                    mesh.userData.tooth
                ) ===
                Number(tooth)
        ) ||
        null
    );
}

function setToothPartVisual(part, options = {}) {
    if (!part || !part.material) return;

    const material = part.material;
    const opacity = options.opacity ?? 1;

    material.transparent = opacity < 1;
    material.opacity = opacity;
    material.emissive.setHex(options.emissiveHex ?? 0x111111);
    material.emissiveIntensity = options.emissiveIntensity ?? 0.08;

    if (options.colorHex && part.userData.colorable) {
        material.color.setStyle(options.colorHex);
    }

    material.needsUpdate = true;
}

function getPreferredOdontogramVisual(
    record
) {
    if (!record) {
        return null;
    }

    if (record.threeD) {
        return record.threeD;
    }

    if (record.status) {
        return record.status;
    }

    const surfaces =
        record.surfaces || {};

    const priority = [
        'center',
        'top',
        'right',
        'bottom',
        'left'
    ];

    for (
        const surface
        of priority
    ) {
        if (surfaces[surface]) {
            return surfaces[surface];
        }
    }

    return null;
}

export function updateOdontogramThreeScene(
    state,
    data = [],
    options = {}
) {
    if (!state) {
        return;
    }

    state.data =
        normalizeOdontogramData(
            data
        );

    const selectedTooth =
        options.selectedTooth ??
        null;

    const dimUnselected =
        Boolean(
            options.dimUnselected
        );

    state.selectedTooth =
        selectedTooth;

    state.selectedMesh =
        selectedTooth
            ? getOdontogramThreeToothMesh(
                state,
                selectedTooth
            )
            : null;

    state.teethMeshes.forEach(
        mesh => {
            const toothNumber =
                Number(
                    mesh.userData.tooth
                );

            const record =
                getOdontogramRecord(
                    state.data,
                    toothNumber
                );

            const visualRecord =
                getPreferredOdontogramVisual(
                    record
                );

            const selected =
                Number(
                    selectedTooth
                ) ===
                toothNumber;

            const shouldDim =
                dimUnselected &&
                selectedTooth &&
                !selected;

            const visualGroup =
                mesh.userData
                    .visualGroup;

            const visualParts =
                mesh.userData
                    .visualParts || [];

            const colorableParts =
                mesh.userData
                    .colorableParts || [];

            visualGroup?.scale.set(
                1,
                1,
                1
            );

            visualParts.forEach(
                part => {
                    setToothPartVisual(
                        part,
                        {
                            opacity:
                                shouldDim
                                    ? 0.34
                                    : 1,

                            emissiveIntensity:
                                shouldDim
                                    ? 0.02
                                    : 0.08
                        }
                    );
                }
            );

            const color =
                visualRecord?.colorHex ||
                '#FFFFF8';

            colorableParts.forEach(
                part => {
                    setToothPartVisual(
                        part,
                        {
                            colorHex:
                                color,

                            opacity:
                                shouldDim
                                    ? 0.40
                                    : 1,

                            emissiveIntensity:
                                shouldDim
                                    ? 0.03
                                    : 0.10
                        }
                    );
                }
            );

            mesh.userData.originalColor =
                color;

            if (visualRecord?.code) {
                mesh.userData.legend =
                    visualRecord.code;
            } else {
                delete mesh.userData.legend;
            }
        }
    );

    if (
        state.selectedMesh &&
        selectedTooth
    ) {
        applySelectedMeshState(
            state.selectedMesh
        );
    }
}

function applySelectedMeshState(mesh) {
    if (!mesh) return;

    const visualGroup = mesh.userData.visualGroup;
    const visualParts = mesh.userData.visualParts || [];
    const colorableParts = mesh.userData.colorableParts || [];

    if (visualGroup) {
        visualGroup.scale.set(1.13, 1.13, 1.13);
    }

    visualParts.forEach(part => {
        setToothPartVisual(part, {
            opacity: 1,
            emissiveHex: 0x8B0000,
            emissiveIntensity: 0.20
        });
    });

    colorableParts.forEach(part => {
        setToothPartVisual(part, {
            opacity: 1,
            emissiveHex: 0x8B0000,
            emissiveIntensity: 0.28
        });
    });
}

function updatePointer(
    state,
    event
) {
    const rect =
        state.renderer
            .domElement
            .getBoundingClientRect();

    state.pointer.x =
        (
            (
                event.clientX -
                rect.left
            ) /
            rect.width
        ) * 2 - 1;

    state.pointer.y =
        -(
            (
                event.clientY -
                rect.top
            ) /
            rect.height
        ) * 2 + 1;
}

function getPointerHit(
    state,
    event
) {
    updatePointer(
        state,
        event
    );

    state.raycaster
        .setFromCamera(
            state.pointer,
            state.camera
        );

    return (
        state.raycaster
            .intersectObjects(
                state.teethMeshes,
                false
            )[0] ||
        null
    );
}

function bindOdontogramPointerEvents(
    state
) {
    const canvas =
        state.renderer.domElement;

    canvas.addEventListener(
        'pointermove',
        event => {
            const hit =
                getPointerHit(
                    state,
                    event
                );

            canvas.style.cursor =
                hit
                    ? 'pointer'
                    : 'grab';

            state.onToothHover?.(
                hit
                    ? Number(
                        hit.object
                            .userData
                            .tooth
                    )
                    : null,
                hit?.object || null,
                event
            );
        }
    );

    canvas.addEventListener(
        'pointerleave',
        event => {
            state.onToothHover?.(
                null,
                null,
                event
            );
        }
    );

    canvas.addEventListener(
        'pointerdown',
        event => {
            const hit =
                getPointerHit(
                    state,
                    event
                );

            if (!hit) {
                if (state.mode === 'editor') {
                    state.onToothClick?.(
                        null,
                        null,
                        event
                    );
                }

                return;
            }

            const mesh =
                hit.object;

            const tooth =
                Number(
                    mesh.userData.tooth
                );

            state.onToothClick?.(
                tooth,
                mesh,
                event
            );
        }
    );
}

function getCurrentOdontogramTheme() {
    const root =
        document.documentElement;

    return (
        root.getAttribute(
            'data-theme'
        ) === 'dark' ||
        root.classList.contains(
            'dark'
        )
    )
        ? 'dark'
        : 'light';
}

function syncOdontogramThreeTheme(
    state,
    theme =
        getCurrentOdontogramTheme()
) {
    if (!state) {
        return;
    }

    const color =
        theme === 'dark'
            ? '#0D1117'
            : '#D8E0EA';

    state.scene.background =
        new THREE.Color(
            color
        );

    state.renderer.setClearColor(
        color,
        1
    );
}

window.addEventListener(
    'global-theme-change',
    event => {
        activeOdontogramStates
            .forEach(state => {
                syncOdontogramThreeTheme(
                    state,
                    event.detail?.theme
                );
            });
    }
);

function startOdontogramAnimation(
    state
) {
    const animate = () => {
        state.animationFrame =
            requestAnimationFrame(
                animate
            );

        state.controls.update();

        state.renderer.render(
            state.scene,
            state.camera
        );
    };

    animate();
}

window.Odontogram3D = {
    create:
        createOdontogramThreeScene,

    update:
        updateOdontogramThreeScene,

    resize:
        resizeOdontogramThreeScene,

    resetCamera:
        resetOdontogramThreeCamera,

    focusTooth:
        focusOdontogramThreeTooth,

    getToothMesh:
        getOdontogramThreeToothMesh
};