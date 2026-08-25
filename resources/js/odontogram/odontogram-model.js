import * as THREE from 'three';

const enamelMaterialProps = {
    color: 0xFFFFF8,
    metalness: 0.02,
    roughness: 0.26,
    emissive: 0x090909,
    emissiveIntensity: 0.04,
    envMapIntensity: 0.95
};

const gumMaterialProps = {
    color: 0xF2A7A2,
    roughness: 0.68,
    metalness: 0.0,
    emissive: 0x220808,
    emissiveIntensity: 0.025
};

const sharedOdontogramGeometries = {
    crown:
        new THREE.SphereGeometry(
            1,
            32,
            22
        ),

    cusp:
        new THREE.SphereGeometry(
            0.105,
            18,
            12
        ),

    hit:
        new THREE.SphereGeometry(
            1,
            16,
            12
        )
};

const sharedOdontogramMaterials = {
    hit:
        new THREE.MeshBasicMaterial({
            color: 0xffffff,
            transparent: true,
            opacity: 0.001,
            depthWrite: false
        })
};

export function getOdontogramToothType(
    toothNumber
) {
    const lastDigit =
        Number(
            String(
                toothNumber
            ).slice(-1)
        );

    if (
        lastDigit === 1 ||
        lastDigit === 2
    ) {
        return 'incisor';
    }

    if (lastDigit === 3) {
        return 'canine';
    }

    if (
        lastDigit === 4 ||
        lastDigit === 5
    ) {
        return 'premolar';
    }

    return 'molar';
}

export function getOdontogramToothDimensions(
    type
) {
    const sizes = {
        incisor: {
            width: 0.34,
            height: 0.50,
            depth: 0.24,
            hitWidth: 0.50,
            hitHeight: 0.66,
            hitDepth: 0.38
        },

        canine: {
            width: 0.36,
            height: 0.54,
            depth: 0.26,
            hitWidth: 0.52,
            hitHeight: 0.70,
            hitDepth: 0.40
        },

        premolar: {
            width: 0.46,
            height: 0.48,
            depth: 0.34,
            hitWidth: 0.62,
            hitHeight: 0.64,
            hitDepth: 0.48
        },

        molar: {
            width: 0.62,
            height: 0.47,
            depth: 0.44,
            hitWidth: 0.78,
            hitHeight: 0.64,
            hitDepth: 0.60
        }
    };

    return sizes[type] ||
        sizes.incisor;
}

function createStandardMaterial(props) {
    return new THREE.MeshStandardMaterial(props);
}

function addVisualPart(group, mesh, visualParts, colorableParts = null) {
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    group.add(mesh);
    visualParts.push(mesh);

    if (colorableParts) {
        mesh.userData.colorable = true;
        colorableParts.push(mesh);
    }

    return mesh;
}

function createSoftCusp(
    x,
    y,
    z,
    scale,
    material
) {
    const cusp =
        new THREE.Mesh(
            sharedOdontogramGeometries
                .cusp,
            material.clone()
        );

    cusp.scale.set(
        1.05 * scale,
        0.50 * scale,
        0.85 * scale
    );

    cusp.position.set(
        x,
        y,
        z
    );

    return cusp;
}

export function createOdontogramTooth(
    toothNumber,
    isUpper = true
) {
    const type =
        getOdontogramToothType(
            toothNumber
        );

    const size =
        getOdontogramToothDimensions(
            type
        );
    const toothGroup = new THREE.Group();

    const visualParts = [];
    const colorableParts = [];

    const enamelMaterial = createStandardMaterial(enamelMaterialProps);
    const crownDirection = isUpper ? -1 : 1;
    const gumDirection = isUpper ? 1 : -1;

    const crown =
        new THREE.Mesh(
            sharedOdontogramGeometries
                .crown,
            enamelMaterial.clone()
        );

    crown.scale.set(size.width, size.height, size.depth);
    crown.position.set(0, crownDirection * 0.22, 0);
    addVisualPart(toothGroup, crown, visualParts, colorableParts);

    const neck = new THREE.Mesh(
        new THREE.CylinderGeometry(size.width * 0.74, size.width * 0.86, 0.12, 26, 1),
        enamelMaterial.clone()
    );

    neck.position.set(0, gumDirection * 0.08, 0);
    addVisualPart(toothGroup, neck, visualParts, colorableParts);

    if (type === 'incisor') {
    }

    if (type === 'canine') {
        const point = new THREE.Mesh(
            new THREE.ConeGeometry(size.width * 0.35, 0.16, 28, 1),
            enamelMaterial.clone()
        );

        point.position.set(0, crownDirection * 0.70, 0);

        if (isUpper) {
            point.rotation.x = Math.PI;
        }

        addVisualPart(toothGroup, point, visualParts, colorableParts);
    }

    if (type === 'premolar') {
        const cuspY = crownDirection * 0.54;
        const cuspA = createSoftCusp(-size.width * 0.20, cuspY, -size.depth * 0.15, 0.90, enamelMaterial);
        const cuspB = createSoftCusp(size.width * 0.20, cuspY, size.depth * 0.15, 0.90, enamelMaterial);

        addVisualPart(toothGroup, cuspA, visualParts, colorableParts);
        addVisualPart(toothGroup, cuspB, visualParts, colorableParts);
    }

    if (type === 'molar') {
        const cuspY = crownDirection * 0.51;
        const cuspPositions = [
            [-size.width * 0.23, cuspY, -size.depth * 0.20],
            [size.width * 0.23, cuspY, -size.depth * 0.20],
            [-size.width * 0.23, cuspY, size.depth * 0.20],
            [size.width * 0.23, cuspY, size.depth * 0.20]
        ];

        cuspPositions.forEach(pos => {
            const cusp = createSoftCusp(pos[0], pos[1], pos[2], 1.0, enamelMaterial);
            addVisualPart(toothGroup, cusp, visualParts, colorableParts);
        });
    }

    const hitMesh =
        new THREE.Mesh(
            sharedOdontogramGeometries
                .hit,
            sharedOdontogramMaterials
                .hit
        );
    hitMesh.scale.set(size.hitWidth, size.hitHeight, size.hitDepth);
    hitMesh.position.set(0, crownDirection * 0.25, 0);

    hitMesh.userData = {
        tooth: toothNumber,
        originalColor: '#FFFFF8',
        visualGroup: toothGroup,
        visualParts,
        colorableParts
    };

    toothGroup.add(hitMesh);

    return {
        group: toothGroup,
        hitMesh: hitMesh
    };
}

export function createOdontogramArch({
    scene,
    teethArray,
    yPosition,
    isUpper = true,
    teethMeshes
}) {
    const group = new THREE.Group();
    const archStartAngle = Math.PI + 0.08;
    const archEndAngle = -0.08;
    const archWidthRadius = 3.18;
    const archDepthRadius = 2.85;

    teethArray.forEach((toothNum, i) => {
        const tooth =
            createOdontogramTooth(
                toothNum,
                isUpper
            );

        const ratio = teethArray.length > 1 ? (i / (teethArray.length - 1)) : 0;
        const sideSign = ratio < 0.5 ? -1 : 1;
        let angle = archStartAngle - ratio * (archStartAngle - archEndAngle);

        const lastDigit = Number(String(toothNum).slice(-1));
        const molarAngleOffsetMap = {
            6: 0.016,
            7: 0.033,
            8: 0.052,
        };
        const molarYNudgeMap = {
            6: 0.05,
            7: 0.08,
            8: 0.11,
        };

        if (molarAngleOffsetMap[lastDigit]) {
            angle += sideSign * molarAngleOffsetMap[lastDigit];
        }

        const x = Math.cos(angle) * archWidthRadius;
        const z = Math.sin(angle) * archDepthRadius;
        const yNudge = molarYNudgeMap[lastDigit]
            ? (isUpper ? molarYNudgeMap[lastDigit] : -molarYNudgeMap[lastDigit])
            : 0;

        tooth.group.position.set(x, yPosition + yNudge, z);
        tooth.group.lookAt(0, yPosition + yNudge, -0.10);

        group.add(tooth.group);
        teethMeshes.push(tooth.hitMesh);
    });

    scene.add(group);
}

export function createOdontogramGumArch({
    scene,
    yPosition,
    isUpper = true
}) {
    const points = [];
    const gumStartAngle = Math.PI + 0.08;
    const gumEndAngle = -0.08;
    const gumWidthRadius = 3.58;
    const gumDepthRadius = 2.92;

    for (let i = 0; i <= 72; i++) {
        const t = i / 72;
        const angle = gumStartAngle - t * (gumStartAngle - gumEndAngle);
        const x = Math.cos(angle) * gumWidthRadius;
        const z = Math.sin(angle) * gumDepthRadius;
        points.push(new THREE.Vector3(x, yPosition, z));
    }

    const curve = new THREE.CatmullRomCurve3(points);

    const mainGeometry = new THREE.TubeGeometry(curve, 96, 0.39, 24, false);
    const mainGum = new THREE.Mesh(mainGeometry, createStandardMaterial(gumMaterialProps));
    mainGum.castShadow = true;
    mainGum.receiveShadow = true;
    scene.add(mainGum);

    const lipPoints = points.map(point => new THREE.Vector3(point.x, point.y + (isUpper ? -0.22 : 0.22), point.z + 0.02));
    const lipCurve = new THREE.CatmullRomCurve3(lipPoints);
    const lipGeometry = new THREE.TubeGeometry(lipCurve, 96, 0.19, 18, false);
    const lipGum = new THREE.Mesh(
        lipGeometry,
        createStandardMaterial({
            ...gumMaterialProps,
            color: 0xF9C4BF,
            roughness: 0.72
        })
    );

    lipGum.castShadow = true;
    lipGum.receiveShadow = true;
    scene.add(lipGum);

    function addGumCover() {
        const coverSegments = 72;
        const vertices = [];
        const indices = [];

        const outerWidthRadius = 3.72;
        const outerDepthRadius = 2.98;
        const innerWidthRadius = 2.92;
        const innerDepthRadius = 2.18;

        const awayFromTeethY = yPosition + (isUpper ? 0.30 : -0.30);
        const nearTeethY = yPosition + (isUpper ? -0.26 : 0.26);

        function pushVertex(x, y, z) {
            vertices.push(x, y, z);
            return (vertices.length / 3) - 1;
        }

        for (let i = 0; i <= coverSegments; i++) {
            const t = i / coverSegments;
            const angle = gumStartAngle - t * (gumStartAngle - gumEndAngle);

            const outerX = Math.cos(angle) * outerWidthRadius;
            const outerZ = Math.sin(angle) * outerDepthRadius;
            const innerX = Math.cos(angle) * innerWidthRadius;
            const innerZ = Math.sin(angle) * innerDepthRadius;

            pushVertex(outerX, awayFromTeethY, outerZ);
            pushVertex(innerX, awayFromTeethY, innerZ);
            pushVertex(outerX, nearTeethY, outerZ);
            pushVertex(innerX, nearTeethY, innerZ);
        }

        for (let i = 0; i < coverSegments; i++) {
            const base = i * 4;
            const next = (i + 1) * 4;

            const outerAway = base;
            const innerAway = base + 1;
            const outerNear = base + 2;
            const innerNear = base + 3;

            const nextOuterAway = next;
            const nextInnerAway = next + 1;
            const nextOuterNear = next + 2;
            const nextInnerNear = next + 3;

            // outer curved wall
            indices.push(outerAway, nextOuterAway, outerNear);
            indices.push(nextOuterAway, nextOuterNear, outerNear);

            // inner curved wall
            indices.push(innerAway, innerNear, nextInnerAway);
            indices.push(nextInnerAway, innerNear, nextInnerNear);

            // away-from-teeth cover surface
            indices.push(outerAway, innerAway, nextOuterAway);
            indices.push(nextOuterAway, innerAway, nextInnerAway);

            // near-teeth cover surface
            indices.push(outerNear, nextOuterNear, innerNear);
            indices.push(nextOuterNear, nextInnerNear, innerNear);
        }

        // close left end
        indices.push(0, 2, 1);
        indices.push(1, 2, 3);

        // close right end
        const last = coverSegments * 4;
        indices.push(last, last + 1, last + 2);
        indices.push(last + 1, last + 3, last + 2);

        const coverGeometry = new THREE.BufferGeometry();
        coverGeometry.setAttribute(
            'position',
            new THREE.Float32BufferAttribute(vertices, 3)
        );
        coverGeometry.setIndex(indices);
        coverGeometry.computeVertexNormals();

        const coverMaterial = createStandardMaterial({
            ...gumMaterialProps,
            color: 0xF3A09B,
            roughness: 0.74,
            side: THREE.DoubleSide
        });

        const coverMesh = new THREE.Mesh(coverGeometry, coverMaterial);
        coverMesh.castShadow = true;
        coverMesh.receiveShadow = true;
        scene.add(coverMesh);
    }

    addGumCover();

    function addGumEndCap(basePoint, lipPoint, sideSign) {
        const mainCap = new THREE.Mesh(
            new THREE.SphereGeometry(0.34, 24, 18),
            createStandardMaterial(gumMaterialProps)
        );
        mainCap.scale.set(1.02, 1.24, 0.96);
        mainCap.position.set(
            basePoint.x + sideSign * 0.06,
            basePoint.y + (isUpper ? 0.01 : -0.01),
            basePoint.z
        );
        mainCap.castShadow = true;
        mainCap.receiveShadow = true;
        scene.add(mainCap);

        const lipCap = new THREE.Mesh(
            new THREE.SphereGeometry(0.20, 20, 14),
            createStandardMaterial({
                ...gumMaterialProps,
                color: 0xF9C4BF,
                roughness: 0.72
            })
        );
        lipCap.scale.set(1.10, 1.16, 0.88);
        lipCap.position.set(
            lipPoint.x + sideSign * 0.08,
            lipPoint.y,
            lipPoint.z + 0.01
        );
        lipCap.castShadow = true;
        lipCap.receiveShadow = true;
        scene.add(lipCap);

        const bridge = new THREE.Mesh(
            new THREE.CylinderGeometry(0.13, 0.13, 0.28, 18, 1),
            createStandardMaterial({
                ...gumMaterialProps,
                color: 0xF6B4AE,
                roughness: 0.70
            })
        );
        bridge.scale.set(0.85, 1.0, 0.72);
        bridge.position.set(
            basePoint.x + sideSign * 0.07,
            (basePoint.y + lipPoint.y) / 2,
            basePoint.z + 0.01
        );
        bridge.rotation.z = Math.PI / 2;
        bridge.castShadow = true;
        bridge.receiveShadow = true;
        scene.add(bridge);
    }

    addGumEndCap(points[0], lipPoints[0], -1);
    addGumEndCap(points[points.length - 1], lipPoints[lipPoints.length - 1], 1);
}