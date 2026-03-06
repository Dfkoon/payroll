<script setup>
import { ref, computed, onMounted, onUnmounted, watch, useAttrs } from 'vue';
import { Motion, Presence } from '@motionone/vue';

const props = defineProps({
  texts: { type: Array, required: true },
  transition: { 
    type: Object, 
    default: () => ({ duration: 0.6, easing: [0.16, 1, 0.3, 1] }) 
  },
  initial: { 
    type: Object, 
    default: () => ({ y: '100%', opacity: 0 }) 
  },
  animate: { 
    type: Object, 
    default: () => ({ y: 0, opacity: 1 }) 
  },
  exit: { 
    type: Object, 
    default: () => ({ y: '-120%', opacity: 0 }) 
  },
  // @motionone/vue doesn't have mode='wait' exactly like framer-motion, 
  // but it supports presence.
  animatePresenceMode: { type: String, default: 'wait' },
  animatePresenceInitial: { type: Boolean, default: false },
  rotationInterval: { type: Number, default: 2000 },
  staggerDuration: { type: Number, default: 0 },
  staggerFrom: { type: [String, Number], default: 'first' },
  loop: { type: Boolean, default: true },
  auto: { type: Boolean, default: true },
  splitBy: { type: String, default: 'characters' },
  mainClassName: { type: String, default: '' },
  splitLevelClassName: { type: String, default: '' },
  elementLevelClassName: { type: String, default: '' },
});

const emit = defineEmits(['next']);

const currentTextIndex = ref(0);
const attrs = useAttrs();

function cn(...classes) {
  return classes.filter(Boolean).join(' ');
}

const splitIntoCharacters = (text) => {
  if (typeof Intl !== 'undefined' && Intl.Segmenter) {
    const segmenter = new Intl.Segmenter('en', { granularity: 'grapheme' });
    return Array.from(segmenter.segment(text), segment => segment.segment);
  }
  return Array.from(text);
};

const actualSplitBy = computed(() => {
  const currentText = props.texts[currentTextIndex.value];
  if (!currentText) return props.splitBy;
  const hasArabic = /[\u0600-\u06FF]/.test(currentText);
  return hasArabic && props.splitBy === 'characters' ? 'words' : props.splitBy;
});

const elements = computed(() => {
  const currentText = props.texts[currentTextIndex.value];
  if (!currentText) return [];

  if (actualSplitBy.value === 'characters') {
    const words = currentText.split(' ');
    return words.map((word, i) => ({
      characters: splitIntoCharacters(word),
      needsSpace: i !== words.length - 1
    }));
  }
  if (actualSplitBy.value === 'words') {
    return currentText.split(' ').map((word, i, arr) => ({
      characters: [word],
      needsSpace: i !== arr.length - 1
    }));
  }
  if (actualSplitBy.value === 'lines') {
    return currentText.split('\n').map((line, i, arr) => ({
      characters: [line],
      needsSpace: i !== arr.length - 1
    }));
  }

  return currentText.split(actualSplitBy.value).map((part, i, arr) => ({
    characters: [part],
    needsSpace: i !== arr.length - 1
  }));
});

const getStaggerDelay = (index, totalChars) => {
  const total = totalChars;
  if (props.staggerFrom === 'first') return index * props.staggerDuration;
  if (props.staggerFrom === 'last') return (total - 1 - index) * props.staggerDuration;
  if (props.staggerFrom === 'center') {
    const center = Math.floor(total / 2);
    return Math.abs(center - index) * props.staggerDuration;
  }
  if (props.staggerFrom === 'random') {
    const randomIndex = Math.floor(Math.random() * total);
    return Math.abs(randomIndex - index) * props.staggerDuration;
  }
  return Math.abs(props.staggerFrom - index) * props.staggerDuration;
};

const next = () => {
  const nextIndex = currentTextIndex.value === props.texts.length - 1 
    ? (props.loop ? 0 : currentTextIndex.value) 
    : currentTextIndex.value + 1;
  
  if (nextIndex !== currentTextIndex.value) {
    currentTextIndex.value = nextIndex;
    emit('next', nextIndex);
  }
};

const previous = () => {
  const prevIndex = currentTextIndex.value === 0 
    ? (props.loop ? props.texts.length - 1 : currentTextIndex.value) 
    : currentTextIndex.value - 1;
  
  if (prevIndex !== currentTextIndex.value) {
    currentTextIndex.value = prevIndex;
    emit('next', prevIndex);
  }
};

const jumpTo = (index) => {
  const validIndex = Math.max(0, Math.min(index, props.texts.length - 1));
  if (validIndex !== currentTextIndex.value) {
    currentTextIndex.value = validIndex;
    emit('next', validIndex);
  }
};

const reset = () => {
  if (currentTextIndex.value !== 0) {
    currentTextIndex.value = 0;
    emit('next', 0);
  }
};

let intervalId = null;

const startRotation = () => {
  if (props.auto) {
    intervalId = setInterval(next, props.rotationInterval);
  }
};

const stopRotation = () => {
  if (intervalId) {
    clearInterval(intervalId);
    intervalId = null;
  }
};

onMounted(startRotation);
onUnmounted(stopRotation);

watch(() => [props.auto, props.rotationInterval], () => {
  stopRotation();
  startRotation();
});

defineExpose({ next, previous, jumpTo, reset });
</script>

<template>
  <Motion 
    :class="cn('text-rotate', mainClassName)" 
    v-bind="attrs"
    :transition="transition"
  >
    <span class="text-rotate-sr-only">{{ texts[currentTextIndex] }}</span>
    <Presence :initial="animatePresenceInitial">
      <Motion
        :key="currentTextIndex"
        :class="cn(actualSplitBy === 'lines' ? 'text-rotate-lines' : 'text-rotate')"
        aria-hidden="true"
      >
        <template v-for="(wordObj, wordIndex) in elements" :key="wordIndex">
          <span :class="cn('text-rotate-word', splitLevelClassName)">
            <Motion
              v-for="(char, charIndex) in wordObj.characters"
              :key="charIndex"
              :initial="initial"
              :animate="animate"
              :exit="exit"
              :transition="{
                ...transition,
                delay: getStaggerDelay(
                  elements.slice(0, wordIndex).reduce((sum, word) => sum + word.characters.length, 0) + charIndex,
                  elements.reduce((sum, word) => sum + word.characters.length, 0)
                )
              }"
              :class="cn('text-rotate-element', elementLevelClassName)"
            >
              {{ char }}
            </Motion>
            <span v-if="wordObj.needsSpace" class="text-rotate-space">&nbsp;</span>
          </span>
        </template>
      </Motion>
    </Presence>
  </Motion>
</template>

<style scoped>
.text-rotate {
  display: flex;
  flex-wrap: wrap;
  white-space: pre-wrap;
  position: relative;
}

.text-rotate-sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.text-rotate-word {
  display: inline-block;
  white-space: nowrap;
}

.text-rotate-lines {
  display: inline-block;
  width: 100%;
}

.text-rotate-element {
  display: inline-block;
}

.text-rotate-space {
  display: inline-block;
  width: 0.25em; /* Explicitly define space width to prevent collapse */
}
</style>
